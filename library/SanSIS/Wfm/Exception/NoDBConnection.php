<?php 

	/**
	 * Classe de exceção
	 * 
	 * @author Pablo Santiago Sánchez <phackwer@gmail.com>
	 * @version 1.0.0
	 * @package SanSIS_Wfm
	 * @subpackage Exception
	 *
	 */

	class SanSIS_Wfm_Exception_NoDBConnection extends SanSIS_Wfm_Exception_Exception
	{
		protected $message = 'Nenhuma conexão de banco de dados foi possível.';
	}

?>