<?php 

/**
 * Exceção para formulário incompleto ou inválido
 *
 * @package		SanSIS
 * @subpackage	Exception
 * @category	Exception
 * @name		Filtro
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */

class SanSIS_Exception_Filtro extends Exception
{
	protected $message = 'Formulário incompleto ou inválido.';
	protected $code    = 'RNS001';
}

?>