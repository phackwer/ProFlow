<?php 

/**
 * Exceção para
 *
 * @package		SanSIS
 * @subpackage	Exception
 * @category	Exception
 * @name		ProhibitedUpdate
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */

class SanSIS_Exception_UploadError extends Exception
{
	protected $message = 'Ocorrera(m) erro(s) no upload do(s) arquivo(s).';
	protected $code    = 'RNS001';
}

?>