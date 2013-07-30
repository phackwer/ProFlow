<?php 

/**
 * Exceção para
 *
 * @package		SanSIS
 * @subpackage	Exception
 * @category	Exception
 * @name		ProhibitedExclusion
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */

class SanSIS_Exception_ProhibitedExclusion extends Exception
{
	protected $message = 'O(s) item(ns) selecionado(s) não pode(m) ser excluído(s).';
	protected $code    = 'RNS001';
}

?>