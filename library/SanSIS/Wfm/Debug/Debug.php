<?php

	/**
	 * Classe abstrata responsável por lidar com as mensagens de debug
	 * Se firephp estiver disponível, permitirá também a depuração via webservices
	 * 
	 * @author Pablo Santiago Sánchez <phackwer@gmail.com>
	 * @version 1.0.0
	 * @package SanSIS_Wfm
	 * @subpackage Debug
	 *
	 */
	abstract class SanSIS_Wfm_Debug_Debug
	{
		/**
		 * Envia mensagens de log para o usuário
		 * @param string $msg
		 * @return void
		 */
		public static function log($msg)
		{
			if (function_exists('fb') && SanSIS_Wfm_Config_Environment::doDebug()){FB::log('Wf message: '.$msg);}
			if (SanSIS_Wfm_Config_Environment::doDebug()) echo "<font color=#009900>LOG: ".$msg."</font><br>\n";
		}
		
		/**
		 * Envia mensagens de informação para o usuário
		 * @param string $msg
		 * @return void
		 */
		public static function info($msg)
		{
			if (function_exists('fb') && SanSIS_Wfm_Config_Environment::doDebug()){FB::info('Wf message: '.$msg);}
			if (SanSIS_Wfm_Config_Environment::doDebug()) echo "<font color=#0000FF>INFO: ".$msg."</font><br>\n";
		}
		
		/**
		 * Envia mensagens de aviso para o usuário
		 * @param string $msg
		 * @return void
		 */
		public static function warn($msg)
		{
			if (function_exists('fb') && SanSIS_Wfm_Config_Environment::doDebug()){FB::warn('Wf message: '.$msg);}
			if (SanSIS_Wfm_Config_Environment::doDebug()) echo "<font color=#999900>WARN: ".$msg."</font><br>\n";
		}
		
		/**
		 * Envia mensagens de erro para o usuário
		 * @param string $msg
		 * @return void
		 */
		public static function error($msg)
		{
			if (function_exists('fb') && SanSIS_Wfm_Config_Environment::doDebug()){FB::error('Wf message: '.$msg);}
			if (SanSIS_Wfm_Config_Environment::doDebug()) echo "<font color=#FF0000>ERROR: ".$msg."</font><br>\n";
		}
		
		/**
		 * Lança exceção para o usuário
		 * @param string $msg
		 * @return void
		 */
		public static function exception($msg)
		{
			if (function_exists('fb') && SanSIS_Wfm_Config_Environment::doDebug()){FB::error($msg);}
			throw new Exception($msg);		
		}
	}
?>