<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	public function _initTranslate()
	{	
		$translator = new Zend_Translate(
			array(
				'adapter' => 'array',
 				'content' => str_replace('public','',PUBLIC_PATH).'/resources/languages/',
				'locale'  => 'pt_BR',
				'scan' => Zend_Translate::LOCALE_DIRECTORY
			)
		);
		Zend_Validate_Abstract::setDefaultTranslator($translator);
	}
	
	public function _initLocale()
	{
		Zend_Locale::setDefault('pt_BR');
	}
	
	public function _initSession()
	{
		Zend_Session::start();
	}
		
	public function _initAutoload()
	{
		$autoloader = new Zend_Loader_Autoloader_Resource(array(
			    'basePath'      => dirname(__FILE__),
			    'namespace'     => 'ProFlow_')
		);
		
		$autoloader->addResourceType('form', 'forms/', 'Form');
		$autoloader->addResourceType('business', 	'business/', 	'Business');
		
		return $autoloader;
	}
}