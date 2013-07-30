<?php 

	/**
	 * Classe de exceчуo
	 * 
	 * @author Pablo Santiago Sсnchez <phackwer@gmail.com>
	 * @version 1.0.0
	 * @package SanSIS_Wfm
	 * @subpackage Exception
	 *
	 */

	class SanSIS_Wfm_Exception_NoProcessByThatIdOnXPDL extends SanSIS_Wfm_Exception_Exception
	{
		protected $message = 'Nenhum processo foi encontrado no XPDL.';
	}

?>