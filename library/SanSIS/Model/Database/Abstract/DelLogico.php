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
abstract class SanSIS_Model_Database_Abstract_DelLogico extends SanSIS_Model_Database_Abstract
{
	//todo o objeto que só tiver del lógico deverá ter este campo na tabela
	public $status_tupla = 1;
	
	//o del lógico apenas realiza o update deste campo para 0
	public function delete($where = null)
	{
		if(!$where)
			$where = ' id = '.$this->id;
			
		$this->preDelete();
		$this->update(
			array('status_tupla' => '0'),
			$where
		);
	}
	
	//ao invés de permitir registros duplicados, o sistema reativará o que foi excluído logicamente
	public function preSave()
	{
		$where = '';
		$and = '';
		//buscar registros anteriores
		foreach($this->_cols as $col)
		{
			if (
				(
					isset($this->_metadata[$col]['DATA_TYPE']) &&
			        $this->_metadata[$col]['DATA_TYPE'] != 'varbit' &&
					$this->_metadata[$col]['DATA_TYPE'] != 'bit' &&
					$this->_metadata[$col]['DATA_TYPE'] != 'integer' &&
					$this->_metadata[$col]['DATA_TYPE'] != 'int4' &&			
					$this->_metadata[$col]['DATA_TYPE'] != 'numeric' &&
					$this->_metadata[$col]['DATA_TYPE'] != 'float' &&
					$this->_metadata[$col]['DATA_TYPE'] != 'timestamp' &&
					$this->_metadata[$col]['DATA_TYPE'] != 'date'
				)
				||
				(
					!isset($this->_metadata[$col]['DATA_TYPE']) && 
					$col != 'id' && 
					$col != 'status_tupla' && 
					$col != 'descricao' &&
					!(strstr($col, 'id_'))
				)
				
			)
			{
				$str = 'translate( \''.$this->$col.'\', '.$this->_matchUTF8AI.')';
				$col = 'translate( '.$col.', '.$this->_matchUTF8AI.')';
				$where .= $and.'lower('.$col.') =  lower('.$str.')';
				$and = ' and ';
			}
			else if
			(
				isset($this->_metadata[$col]['DATA_TYPE']) && 
				(
					$this->_metadata[$col]['DATA_TYPE'] == 'timestamp' ||
					$this->_metadata[$col]['DATA_TYPE'] == 'date' ||
					$this->_metadata[$col]['DATA_TYPE'] == 'bit'
				)
			)
			{
				//não faz nada, lá lá lá lá lá!
				//para estes tipos de coluna, a filtragem deve ser nula
			}
			else if ($col != 'id' && $col != 'status_tupla' &&  $col != 'descricao' )
			{
				if (isset($this->$col))
				{
					if (!$this->$col)
						$where .= $and.$col.' is null';
					else
						$where .= $and.$col.' =  '.$this->$col;
					$and = ' and ';
				}
			}
		}
		
		//isto é necessário para evitar que compare a si mesmo
		if ($this->id)
			$where .= ' and id <> '.$this->id;
		
		//primeiro checamos se já não existe mas está excluído logicamente
		//neste caso, reativamos o registro excluído logicamente apenas
		$counter = 0;
		$delobjs = $this->getAll($where.' and status_tupla = \'0\'');
		
		foreach ($delobjs as $delobj)
		{
			$delobj->status_tupla = 1;
			$delobj->save();
			$this->id = $delobj->id;
		}

		if (count($delobjs) > 0)
			return;
		
		//agora checamos se já existe e não está excluído logicamente
		//neste caso, lançamos exceção de erro
		$delobjs = $this->getAll($where.' and status_tupla = \'1\'');
		
		if (count($delobjs))
		{
			throw new SanSIS_Exception_DuplicateEntry();
		}
		
		//finalmente, executamos o preSave original
		parent::preSave();
	}
}