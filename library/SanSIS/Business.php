<?php
/**
 * Business para camada Business.
 *
 * @package		SanSIS
 * @category	Business
 * @name		Business
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class SanSIS_Business
{
	//baseurl
	public $baseurl;
	public $crudClass;
	public $crudObj;
	public $user;
	
	/**
	 * Constructor - tem o objetivo básico de garantir o atendimento
	 * ao padrão definido pela Arquitetura, impedindo o instanciamento
	 * fora do contexto adequado
	 */
	public function __construct()
	{
		if (APPLICATION_ENV == 'development')
		{
			$debug = debug_backtrace ( true );
			if (
				! ($debug [1] ['object'] instanceof SanSIS_Controller_Action) &&
				! ($debug [1] ['object'] instanceof SanSIS_Business)
				)
			{
				echo '<pre>';
				echo 'Arquivo:  ' . $debug [0] ['file'] . '<br>';
				echo 'Linha:	' . $debug [0] ['line'] . '<br>';
				echo 'Classe:   ' . $debug [0] ['class'] . '<br>';
				echo 'Erro:	 Business só pode ser instanciado na Controller';
				die ();
			}
		}

		if (Zend_Db_Table::getDefaultAdapter())
		{
			if ($this->crudClass)
				$this->crudObj = new $this->crudClass;
		
			$this->user = new SanSIS_Model_Auth_Usuario();
		}
	}
	
	public function authenticate($user, $pwd)
	{
		return $this->user->authenticate($user, $pwd);
	}
	
	public function checkACL($module, $controller)
	{
		$acl = new SanSIS_Model_Auth_PerfilAcesso();
		return $acl->checkACL($module, $controller);
	}
	
	/**
	 * Busca uma lista com bases em critérios repassados
	 * A implementação da filtragem dos parâmetros deverá estar na Model
	 * @params array Parâmetros enviados pelo formulário
	 */
	public function getList($params = null)
	{  
		return $this->crudObj->getList($params);
	}
	
	/**
	 * Retorna o mapeamento do objeto para popular o formulário
	 * Deve ser implantado de acordo com a Business
	 */
	public function getMapping()
	{
		return $this->crudObj->getCols();
	}
	
	/**
	 * Obtém os dados para popular selects, radios, etc do formulário
	 * Deve ser implantado de acordo com a Business
	 */
	public function getFormData($id = null)
	{
	}
	
	/**
	 * Prepara a lista para a query. Provavelmente, desta forma, servirá para
	 * praticamente todas as pesquisas. Reescreva apenas caso a pesquisa requeira.
	 * @param $param
	 */
	public function getListQuery($object, $params)
	{
	  $and = "";
	  $query = "";
		
	  foreach ($params as $param => $value)
	  {
		if ($value)
		{
		  $query .= $and.$param." = ".$value;
		  $and = " and ";
		}
	  }	  
	  
	  if ($query)
		return $query;
	  else
		return null;
	}
	
	/**
	 * Carrega objetos para edição
	 * Deve ser implantado de acordo com a Business
	 */
	public function load($id)
	{
		return $this->crudObj->load($id);
	}
	
	/**
	 * Salva dados submetidos
	 * Deve ser implantado de acordo com a Business
	 */
	public function save($values)
	{
		$cols = $this->getMapping();
		
		foreach($cols as $value)
		{
			if (isset($values[$value]))
				$this->crudObj->$value = $values[$value];
			else
				$this->crudObj->$value = null;
		}
		
		$this->crudObj->save();
	}
	
	/**
	 * Remove registro do banco
	 * Deve ser implantado de acordo com a Business
	 */
	public function delete($objeto)
	{
		$objeto->delete();
	}
	
	public function getLocalizacaoFormData($values = null)
	{
		$data 			= array();
		$data['pais'] 	= array();
		$data['uf'] 	= array();
		$data['cidade'] = array();
		
		$src = new ProFlow_Business_Pais();
		$paises = $src->getList();
		
		foreach($paises as $pais)
			$data['pais'][$pais['id']] = $pais['nome'];
		
		if (isset($values['id']) || isset($values['id_pais']))
		{
			$src = new ProFlow_Business_Uf();
			
			if (isset($values['id']) && $values['id'] && (!isset($values['id_pais']) || !$values['id_pais']))
			{
				$this->crudObj->load($values['id']);
				$values['id_uf'] = $this->crudObj->id_uf;
				if ($values['id_uf'])
					$values['id_pais'] = $src->load($values['id_uf'])->id_pais;
			}
			
			if (isset($values['id_pais']) && $values['id_pais'])
			{
				$ufs = $src->getList(array("id_pais" => $values['id_pais']));
				
				foreach($ufs as $uf)
					$data['uf'][$uf['id']] = $uf['nome'];
			}
			
			if (isset($values['id_uf']) && $values['id_uf'])
			{
				$src = new ProFlow_Business_Cidade();
				$cidades = $src->getList(array("id_uf" => $values['id_uf']));
				
				foreach($cidades as $cidade)
					$data['cidade'][$cidade['id']] = $cidade['nome'];
			}
		}
		
		return $data;
	}
}
