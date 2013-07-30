<?php 

/**
 * Exceção para
 *
 * @package		SanSIS
 * @subpackage	Exception
 * @category	Exception
 * @name		NoRecordsSelected
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */

class SanSIS_Exception_NoRecordsSelected extends Exception
{
	protected $message = 'Por favor selecione pelo menos um registro.';
	protected $code    = 'RNS001';
}

?>