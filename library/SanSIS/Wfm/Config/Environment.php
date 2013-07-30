<?php 

	/**
	 * Classe abstrata responsсvel por lidar com as diversas configuraчѕes
	 * que serуo utilizadas pela engine. Contщm em seu interior uma instтncia
	 * de Zend_Config_Ini exclusiva para o SanSIS_Wfm
	 * 
	 * @author Pablo Santiago Sсnchez <phackwer@gmail.com>
	 * @version 1.0.0
	 * @package SanSIS_Wfm
	 * @subpackage Config
	 *
	 */
	abstract class SanSIS_Wfm_Config_Environment
	{
		//Constantes necessсrias
        //constantes de estado do objeto de execuчуo (processo/atividade)
        const WF_OPENED         = 1;
        const WF_STARTED        = 2;
        const WF_ENDED          = 3;
        const WF_ABORTED        = 4;
        const WF_SUSPENDED      = 5;
        
        //constantes para tipos de eventos
        const WF_EV_CREATION    = 1;
        const WF_EV_ASSIGN      = 2;
        const WF_EV_STATE       = 3;
        const WF_EV_DATA        = 4;
        const WF_EV_END         = 5;
        
        //constantes para prioridades
        const WF_PRIOR_LOW      = 1;
        const WF_PRIOR_NORMAL   = 2;
        const WF_PRIOR_HIGH     = 3;
        
        //controle de debug
        private static $debug   = false;
        
        //instтncia de configuraчуo
        private static $config;
		
		/**
		 * Retorna o Objeto de Configuraчуo para um dado ambiente
		 * @param string $name - se nуo for informado, utiliza o padrуo
		 * @return WfConfig
		 */
		public function getConfig()
		{
			if (!isset(self::$config))
			{
				try
				{
				    self::$config = new Zend_Config_Ini(APPLICATION_CONFIGS.DIRECTORY_SEPARATOR.'sansis_wfm.ini', 'wfm');
				    self::activateDebug(self::$config->debug);
				}
				catch (Exception $e)
				{
					throw new SanSIS_Wfm_Exception_NoConfigurationFound();
				}
			}
			
			return self::$config;
		}
		
		/**
		 * Define se deve ser ativada a depuraчуo
		 * @param bool $bool
		 * @return void
		 */
		public function activateDebug($bool = false)
		{
			SanSIS_Wfm_Debug_Debug::log('Depuraчуo definida para '.(int)$bool.'.');
			self::$debug = $bool;
			SanSIS_Wfm_Debug_Debug::log('Depuraчуo definida para '.(int)$bool.'.');
		}
		
		/**
		 * Retorna o status do parтmetro de debug
		 * @return bool
		 */
		public function doDebug()
		{
			return self::$debug;
		}
	}

?>