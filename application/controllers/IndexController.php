<?php

class IndexController extends SanSIS_Controller_Action
{
	protected $title		= 'Tela Inicial';
	protected $subtitle		= 'Informações sobre o ProFlow';
	
	public function indexAction()
	{
		$this->setSubTitle($this->subtitle);
		
		$auth = Zend_Auth::getInstance();
		if (!$auth->getIdentity())
			$this->addMessage(SanSIS_Message::TYPE_INFO, SanSIS_Message::MSG_RESTRICTACCESS, '/login/index/');
		
		$this->view->perfil = $auth->getIdentity()->user->perfil;
	}
}

