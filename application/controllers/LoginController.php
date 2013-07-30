<?php

class LoginController extends SanSIS_Controller_CrudHTML
{
	protected $bizClassName 			= 'Admin_Business_Usuario';
	protected $title 					= 'Login';
	protected $loginSubTitle 			= 'Identificação requerida para acesso';
	
	protected $actionMenu				= array();
	
	protected $editSubTitle 			= 'Dados do usuário';
	protected $editFormClassName 		= 'SanSIS_Form_MeusDados';
	protected $editSucessTarget 		= '/default/login/edit';
	protected $editSucessMessage 		= 'Operação realizada com sucesso. Para efetivar as alterações, efetue o logout, e então o login novamente.';
	protected $editFailureTarget 		= '/default/login/edit';
	protected $editCancelTarget 		= '/';
	protected $editInfoMessage 			= 'Edite aqui seus dados cadastrais. Deixe senha em branco para não alterá-la. Campos desabilitados só podem ser alterados pelos administradores.';
	
	public function indexAction()
	{
		$this->loginAction();
	}
	
	public function preEdit()
	{
		$this->getRequest()->setParam('id',Zend_Auth::getInstance()->getIdentity()->user->id);
	}
}

