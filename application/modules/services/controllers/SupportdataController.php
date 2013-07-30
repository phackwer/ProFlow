<?php

class Services_SupportdataController extends SanSIS_Controller_Action
{

	/**
	 * Inicializa a action, checando itens como segurança e preparando o ambiente
	 */
	public function init()
	{
		$this->checkReferer();
		$this->_helper->layout()->disableLayout();
		
		parent::init();
	}

	public function indexAction()
	{
		$this->getRequest()->setControllerName('Index');
	}
	
	/**
	 * Método para evitar uso indevido dos recursos do ProFlow
	 */
	public function checkReferer()
	{
		if (
			(
				!isset($_SERVER['HTTP_REFERER'])
				|| 
				!strstr($_SERVER['HTTP_REFERER'], 'http://'.$_SERVER['SERVER_NAME'])
			)
			&&
			APPLICATION_ENV != 'development'
		)
		die('Busted! IP: '.$_SERVER['REMOTE_ADDR'].' log time: '.date('Y-m-d H:i:s'));
	}
	
	public function ufAction()
	{
		$values = $this->getRequest()->getParams();
		$biz = new ProFlow_Business_Uf();
		$this->view->list = $biz->getlistufspais($values);
	}
	
	/**
	* Action para carregar combos por AJAX
	*/
	public function cidadeAction()
	{
		$values = $this->getRequest()->getParams();
		$biz = new ProFlow_Business_Cidade();
		$this->view->list = $biz->getlistcidadesuf($values);
	}
	
	public function pesquisausuariosAction()
	{
		$values = $this->getRequest()->getParams();
		$values['nome'] = $values['query'];
		$biz = new Admin_Business_Usuario();
		$this->view->list = $biz->getList($values);
		$this->view->query = $values['query'];
	}
}

