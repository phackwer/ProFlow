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

class SanSIS_Exception_ProhibitedUpdate extends Exception
{
	protected $message = 'O(s) item(ns) selecionado(s) não pode(m) ser atualizado(s).';
	protected $code    = 'RNS001';
}

?>