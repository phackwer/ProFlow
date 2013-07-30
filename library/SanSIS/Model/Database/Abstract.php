<?php

/**
 * Modelo Abstrato para acesso ao banco de dados
 *
 * @package		SanSIS
 * @subpackage	Model
 * @category	Database
 * @name		Abstract
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */
abstract class SanSIS_Model_Database_Abstract extends Zend_Db_Table_Abstract
{
	/**
	 * máscara para pesquisa accent insensitive com UTF8 no Postgres
	 * @var string
	 */
	protected $_matchUTF8AI = "'\303\200\303\201\303\202\303\203\303\204\303\205\303\206\303\207\303\210\303\211\303\212\303\213\303\214\303\215\303\216\303\217\303\221\303\222\303\223\303\224\303\225\303\226\303\230\303\231\303\232\303\233\303\234\303\235\303\237\303\240\303\241\303\242\303\243\303\244\303\245\303\246\303\247\303\250\303\251\303\252\303\253\303\254\303\255\303\256\303\257\303\261\303\262\303\263\303\264\303\265\303\266\303\270\303\271\303\272\303\273\303\274\303\275\303\277','AAAAAAACEEEEIIIINOOOOOOUUUUYSaaaaaaaceeeeiiiinoooooouuuuyy'";
	protected $_schema   = 'public';
	protected $_saveType;
	protected $_parent;
	protected $_parentObj;
	protected $_config;
	public $id;
	
	/**
	 * Construtor padrão para as classes
	 * Caso seja necessário reescrever o construtor, chame o construtor do parent
	 * antes de declarar as redefinições
	 * 
	 * @param integer $id - id do objeto no banco de dados
	 * @param $config
	 * @param $definition
	 */
	public function __construct($id = null, $config = null, $definition = null)
	{		
		parent::__construct($config, $definition);
		
		if (APPLICATION_ENV == 'development')
		{
			$debug = debug_backtrace(true);
			
			if(!($debug [1] ['object'] instanceof SanSIS_Business)&& !($debug [1] ['object'] instanceof SanSIS_Model_Database_Abstract))
			{
				$msg = '<br>';
				$msg .= 'Arquivo:		' . $debug [0] ['file'] . '<br>';
				$msg .= 'Linha:			' . $debug [0] ['line'] . '<br>';
				$msg .= 'Classe:		' . $debug [0] ['class'] . '<br>';
				$msg .= 'Classe pai:	' . $debug [1] ['class'] . '<br>';
				$msg .= 'Erro:			Model só pode ser instanciado na Business ou na Model<br><br>';
				
				throw new Exception($msg);
			}
		}
		
		parent::__construct($config, $definition);
		$this->_config = new Zend_Config_Ini(APPLICATION_PATH.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'application.ini', APPLICATION_ENV);
		
		if ($this->_parent)
			$this->_parentObj = new $this->_parent();
		
		if($id)
			$this->load($id);
	}
	
	/**
	 * Comandos que devem ser executados antes do save
	 * Por padrão, divide em preInsert e preUpdate, mas não é obrigatório
	 * implantar desta forma. Pode ser apenas reescrito.
	 */
	public function preSave()
	{
		if(!$this->id)
			$this->preInsert();
		else
			$this->preUpdate();
	}
	
	/**
	 * Comandos para executar antes de uma inserção
	 * Por padrão, em branco, depende da implementação no objeto 
	 */
	public function preInsert()
	{
	}
	
	/**
	 * Comandos para executar antes de uma atualização
	 * Por padrão, em branco, depende da implementação no objeto 
	 */
	public function preUpdate()
	{
	}
	
	/**
	 * Comandos que devem ser executados após o save
	 * Por padrão, em branco, depende da implementação no objeto 
	 */
	public function postSave()
	{
		if($this->_saveType == 'insert')
			$this->postInsert();
		else
			$this->postUpdate();
	}
	
	/**
	 * Comandos para executar após uma inserção
	 * Por padrão, em branco, depende da implementação no objeto 
	 */
	public function postInsert()
	{
	}
	
	/**
	 * Comandos para executar após uma atualização
	 * Por padrão, em branco, depende da implementação no objeto 
	 */
	public function postUpdate()
	{
	}
	
	/**
	 * Salva o objeto no banco de dados
	 */
	public function save()
	{
		try
		{
			$this->preSave();
			
			$data = array();
			foreach($this->_cols as $name)
			{
				if($name != 'id' && isset($this->$name))
				{
					if (!$this->$name && $this->$name !== '0' && $this->$name !== 0 && $this->$name !== '')
					{
						$data[$name] = null;
					}
					else
					{
						if (
							isset($this->_metadata[$name]['DATA_TYPE']) && 
							(
								$this->_metadata[$name]['DATA_TYPE'] == 'timestamp' ||
								$this->_metadata[$name]['DATA_TYPE'] == 'date'
							)
						)
						{
							$this->$name;
							$data[$name] = $this->brdate2isodate($this->$name);
						}
						else if (
							isset($this->_metadata[$name]['DATA_TYPE']) &&
							( 
								$this->_metadata[$name]['DATA_TYPE'] == 'integer' || 
								$this->_metadata[$name]['DATA_TYPE'] == 'int4'
							)
						)
						{
							if ($this->$name === '')
								$data[$name] = null;
							else
								$data[$name] = (int) $this->$name;
						}
						else if (
							isset($this->_metadata[$name]['DATA_TYPE']) &&
							( 
								$this->_metadata[$name]['DATA_TYPE'] == 'numeric' ||
								$this->_metadata[$name]['DATA_TYPE'] == 'float'
							)
						)
						{
							$data[$name] = (float) $this->$name;
						}
						else
						{
							$data[$name] = (string) $this->$name;
						}
					}
						
				}
			}
			
			if($this->id)
			{
				$this->update($data, $this->getAdapter()->quoteInto(' id = ?', $this->id));
				$this->_saveType = 'update';
			}
			else
			{
				$this->id = $this->insert($data);
				$this->_saveType = 'insert';
			}
			
			$this->postSave();
			
			return $this;
		}
		catch (Exception $e)
		{
			$this->getAdapter()->rollBack();
			throw new SanSIS_Exception_DatabaseError($e->getMessage());
		}
	}
	
	/**
	 * Carrega objetos com base no id dos mesmos
	 * 
	 * @param integer $id
	 */
	public function load($id, $forUpdate = false)
	{
		if(!$id)
			throw new SanSIS_Exception_NoId();
		
		$where = $this->getAdapter()->quoteInto(' id = ?', $id);
		
		$select = $this->select()
					->setIntegrityCheck(false)
					->from(array('objeto' => $this->_schema.'.'.$this->_name));
					
		if ($this->_parent)
		{
			$this->parentJoins($select);
		}
					
		$select->where($where);
		
		if ($forUpdate)
			$select->forUpdate();
		
		$row = $this->getRow($select);
		
		if ($row)
		{
			//@TODO - passar os dados para o pai do qual se herdou
			foreach($this->_cols as $name)
			{
				if(is_resource($row->$name))
					$this->$name = stream_get_contents($row->$name);
				else
				{
					if (
							isset($this->_metadata[$name]['DATA_TYPE']) && 
							(
								$this->_metadata[$name]['DATA_TYPE'] == 'timestamp' ||
								$this->_metadata[$name]['DATA_TYPE'] == 'date'
							)
					)
					{
						$this->$name = $this->isodate2brdate($row->$name);
					}
					else
					{
						$this->$name = $row->$name;
					}
				}
			}
			
			return $this;
		}
		else
			throw new SanSIS_Exception_NoObjectForId();
	}
	
	public function getParentModelName()
	{
		$parentModelName = explode('_',$this->_parent);
		return $parentModelName[(count($parentModelName) - 1)];
	}
	
	public function parentJoins($select)
	{
		$parentModelName = $this->getParentModelName();
		$select->join(array(
			$parentModelName => $this->_parentObj._schema.'.'.$this->_parentObj._name,
			$this->_name.'.id = '.$parentModelName.'.id'
		));
		if ($this->_parentObj->_parent)
		{
			$this->_parentObj->parentJoins($select);
		}
		
		echo $select->assemble();
	}
	
	/**
	 * Reescreve o método original fetchAll
	 * 
	 * @param string|array|Zend_Db_Table_Select	$where		OPTIONAL An SQL WHERE clause or Zend_Db_Table_Select object.
	 * @param string|array						$order		OPTIONAL An SQL ORDER clause.
	 * @param int								$count		OPTIONAL An SQL LIMIT count.
	 * @param int								$offset		OPTIONAL An SQL LIMIT offset.
	 * @param string							$returnType	if return is an array of objects or a multidimensional array
	 * 
	 * @return array
	 */
	public function getAll($where = null, $order = null, $count = null, $offset = null, $returnType = 'obj')
	{
		$result = parent::fetchAll($where, $order, $count, $offset);
		
		$newResult = array();
		$counter = 0;
		
		if($returnType == 'obj')
		{
			$classname = get_class($this);
			
			foreach($result as $row)
			{
				$newResult [$counter] = new $classname();
				
				foreach($this->_cols as $name)
				{
					//@TODO - CLOB no Oracle não funciona com mais de um resultado
					if(isset($row [$name]))
					{
						if(is_resource($row [$name]))
						{
							//esta linha deveria funcionar corretamente
							//bug da PDO
							$content = stream_get_contents($row [$name]);
							$newResult [$counter]->$name = $content;
						}
						else
						{
							if (
									isset($this->_metadata[$name]['DATA_TYPE']) && 
									$this->_metadata[$name]['DATA_TYPE'] == 'timestamp'
							)
							{
								$newResult [$counter]->$name = $this->isodate2brdate($row [$name]);
							}
							else
							{
								$newResult [$counter]->$name = $row [$name];
							}
						}
					}
				}	
				$counter ++;
			}
		}
		else
		{
			foreach($result as $row)
			{
				$newResult [$counter] = array();
				
				foreach ($row as $name => $value)
				{
					if (
							isset($this->_metadata[$name]['DATA_TYPE']) && 
							$this->_metadata[$name]['DATA_TYPE'] == 'timestamp'
					)
					{
						$newResult [$counter][$name] = $this->isodate2brdate($row [$value]);
					}
					else
					{
						$newResult [$counter][$name] = $value;
					}
				}
					
				$counter ++;
			}
		}
		
		return $newResult;
	}
	
	/**
	 * Reescreve o método original fetchRow para que o retorno seja com o nome dos metas
	 *
	 * @param string|array|Zend_Db_Table_Select	$where		OPTIONAL An SQL WHERE clause or Zend_Db_Table_Select object.
	 * @param string|array						$order		OPTIONAL An SQL ORDER clause.
	 * @param string							$returnType	if return is an objects or an array
	 * @return mixed
	 */
	public function getRow($where = null, $order = null, $returnType = 'obj')
	{				
		$result = parent::fetchRow($where, $order);
		
		if ($result)
		{
			if($returnType == 'obj')
			{
				$classname = get_class($this);
				$newResult = new $classname();		
				foreach($this->_cols as $name)
				{
				
					if (
							isset($this->_metadata[$name]['DATA_TYPE']) && 
							$this->_metadata[$name]['DATA_TYPE'] == 'timestamp'
					)
					{
						$newResult->$name = $this->isodate2brdate($result->$name);
					}
					else
					{
						$newResult->$name = $result->$name;
					}
				}
			}
			else
			{
				$newResult = array();
				foreach ($result as $name => $value)
				{
					if (
							isset($this->_metadata[$name]['DATA_TYPE']) && 
							$this->_metadata[$name]['DATA_TYPE'] == 'timestamp'
					)
					{
						$newResult[$name] = $this->isodate2brdate($result->$name);
					}
					else
					{
						$newResult[$name] = $result->$name;
					}
					
				}
			}
			
			return $newResult;
		}
		else
			return null;
	}
	
	public function preDelete()
	{
	}
	
	public function postDelete()
	{
	}
	
	public function delete($where = null)
	{
		if(!$where)
			$where = ' id = '.$this->id;
		$this->preDelete();
		parent::delete($where);
		$this->postDelete();
	}
	
	public function getCols()
	{
		return $this->_cols;
	}
	
	public function isodate2brdate($isodate)
	{
		if (!$isodate || strstr($isodate, '/'))
			return $isodate;
			
		$datetime = explode(' ', $isodate);
		
		$date = explode('-', $datetime[0]);
		
		if (isset($datetime[1]))
			$brdate = $date[2].'/'.$date[1].'/'.$date[0].' '.$datetime[1];
		else
			$brdate = $date[2].'/'.$date[1].'/'.$date[0];
		
		return $brdate;
	}
	
	public function brdate2isodate($brdate)
	{
		if (!$brdate || strstr($brdate, '-'))
			return $brdate;
			
		$datetime = explode(' ', $brdate);
		
		$date = explode('/', $datetime[0]);
		
		if (isset($datetime[1]))
			$isodate = $date[2].'-'.$date[1].'-'.$date[0].' '.$datetime[1];
		else
			$isodate = $date[2].'-'.$date[1].'-'.$date[0];
		
		return $isodate;
	}
	
	public function getAbsDateTime($dthr)
	{
		$dthr = $this->brdate2isodate($dthr);
		$dthr = str_replace(array(' ','-',':'), '', $dthr);
		return $dthr;
	}
}