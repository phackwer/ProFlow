<?php 

/**
 * Exceção para
 *
 * @package		SanSIS
 * @subpackage	Exception
 * @category	Exception
 * @name		NoId
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */

class SanSIS_Exception_NoId extends Exception
{
	protected $message = 'Nenhum Id informado para carregar o objeto.';
	protected $code    = 'RNS001';
}

?>