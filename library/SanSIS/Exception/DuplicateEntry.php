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

class SanSIS_Exception_DuplicateEntry extends Exception
{
	protected $message = 'Não foi possível salvar. Informação já existe no banco de dados.';
	protected $code    = 'RNS001';
}

?>