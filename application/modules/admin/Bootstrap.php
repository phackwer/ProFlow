<?php

class Admin_Bootstrap extends Zend_Application_Module_Bootstrap
{	
	public function _initAutoload()
	{
		$autoloader = new Zend_Application_Module_Autoloader(array(
				'basePath'	  	=> dirname(__FILE__),
				'namespace'	 	=> 'Admin_')
		);
		
		$autoloader->addResourceType('form', 		'forms/', 		'Form');
		$autoloader->addResourceType('business', 	'business/', 	'Business');
		
		return $autoloader;
	}
}