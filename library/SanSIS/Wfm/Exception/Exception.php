<?php

	/**
	 * Classe de exceзгo
	 * 
	 * @author Pablo Santiago Sбnchez <phackwer@gmail.com>
	 * @version 1.0.0
	 * @package SanSIS_Wfm
	 * @subpackage Exception
	 *
	 */

	class SanSIS_Wfm_Exception_Exception extends Exception
	{
		protected $message = 'Exceзгo genйrica do SanSIS_Wfm - Entre em contato com o desenvolvedor';
		
		public function _construct()
		{
			SanSIS_Wfm_Debug_Debug::exception($this->message);
		}
	}

?>