<?php

date_default_timezone_set('America/Sao_Paulo');

define('PUBLIC_PATH', dirname($_SERVER['SCRIPT_FILENAME']));

//redirect to the right path
if ( !strstr($_SERVER['REQUEST_URI'], 'index.php/'))
{
    header('Location: index.php/');
    die;
}

ini_set ( 'error_reporting' , E_ALL );

// Define path to application directory
defined('APPLICATION_PATH')
	|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
	|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
	realpath(APPLICATION_PATH . '/../library'),
	get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
	APPLICATION_ENV,
	APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
			->run();