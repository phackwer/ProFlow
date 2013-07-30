<?php

/**
 * Controller Administrativo de Index
 *
 * @package		Admin
 * @category	Controller
 * @name		Index
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */
class Admin_IndexController extends SanSIS_Controller_Action
{
	protected $bizClassName 			= 'ProFlow_Business_Usuario';
	
	public function indexAction()
	{
		if (!Zend_Auth::getInstance()->getIdentity())
		{
			$params = $this->getRequest()->getParams();
			header('Location: '.$this->baseurl.'/login/index/target/'.$params['module'].'|'.$params['controller']);
		}
	}


}

