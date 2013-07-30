<?php

/**
 * Business de Usuário
 *
 * @package		Admin
 * @category	Business
 * @name		Usuario
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class Admin_Business_Usuario extends SanSIS_Business
{
	public $crudClass = 'SanSIS_Model_Auth_Usuario';
	
	public function getList($params = null)
	{
		return $this->crudObj->getList ($params);
	}
	
	/**
	 * Retorna o mapeamento do objeto para popular o formulário
	 * Deve ser implantado de acordo com a Business
	 */
	public function getMapping()
	{
		$cols = parent::getMapping();

		$cols[] = 'id_perfil';
		
		return $cols;
	}
	
	/**
	* Carrega objetos para edição
	* Deve ser implantado de acordo com a Business
	*/
	public function load($id = null, $forUpdate = false)
	{
		$auth = Zend_Auth::getInstance();
		
		if (!$id && $auth->getIdentity())
			return $this->crudObj->load($auth->getIdentity()->user->id);
		else
			return $this->crudObj->load($id);
	}
	
	/**
	 * Salva dados submetidos
	 * Deve ser implantado de acordo com a Business
	 */
	public function save($values)
	{
		$current = Zend_Auth::getInstance()->getIdentity()->user;
		//se usuário não for root ou admin, assumimos que está editando a própria conta
		if (!isset($current->perfil['root']) && !isset($current->perfil['admin']))
			$values['id'] = Zend_Auth::getInstance()->getIdentity()->user->id;
		//salvamos os dados do usuário
		parent::save($values);
		//salvamos as permissões
		if ((isset($current->perfil['root']) || isset($current->perfil['admin'])) && isset($values['id_perfil']))
			$this->crudObj->savePerfis($values);
	}
	
	/**
	* Salva dados para a instalação
	* Deve ser implantado de acordo com a Business
	*/
	public function saveInstall($values)
	{
		if (file_exists(APPLICATION_PATH.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'configuration.ini'))
		{
			//salvamos os dados do usuário
			parent::save($values);
			//salvamos as permissões
			$this->crudObj->savePerfis($values);
		}
	}
	
	public function getPerfisList()
	{
		$obj = new SanSIS_Model_Auth_PerfilAcesso();
		return $obj->getList();
	}
	
	public function getFormData($values = null)
	{
		$data = $this->getLocalizacaoFormData($values);
		
		$src = new SanSIS_Model_Auth_PerfilAcesso();
		$list = $src->getList();
		
		foreach ($list as $perfil)
			$data['perfil'][$perfil['id']] = $perfil['nome'];
		
		$src = new ProFlow_Model_Departamento();
		$list = $src->getList();
		
		foreach ($list as $dept)
			$data['departamento'][$dept['id']] = str_replace('&nbsp;', '-', $dept['nome']);
		
		return $data;
	}
}