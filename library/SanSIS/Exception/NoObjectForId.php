<?php 

/**
 * Exceção para entrada duplicada
 *
 * @package		SanSIS
 * @subpackage	Exception
 * @category	Exception
 * @name		DuplicateEntry
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */

class SanSIS_Exception_NoObjectForId extends Exception
{
	protected $message = 'Não foi possível encontrar um objeto com o ID informado no banco de dados.';
	protected $code    = 'RNS001';
}

?>