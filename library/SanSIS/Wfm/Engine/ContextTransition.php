<?php 
	
	/**
	 * Classe responsсvel por conter a interpretaчуo da Transiчуo de Atividade
	 * do XPDL para utilizaчуo no contexto do processo em execuчуo
	 * 
	 * @author Pablo Santiago Sсnchez <phackwer@gmail.com>
	 * @version 1.0.0
	 * @package SanSIS_Wfm
	 * @subpackage Engine
	 *
	 */
	class SanSIS_Wfm_Engine_ContextTransition extends SanSIS_Wfm_Base
	{
		//atributos requeridos
		private $process;					//Processo ao qual a Transiчуo pertence
		private $id;						//id
		private $from;						//Atividade de origem da Transiчуo
		private $to;						//Atividade de destino da Transiчуo		
		
		/**
		 * Definiчуo XPDL da transiчуo jс carregada em um DOMElement
		 * @param DOMElement $processNode
		 */
		public function __construct(DOMElement $processNode, SanSIS_Wfm_Engine_ContextProcess $process)
		{
			$this->process			= $process;
			$this->id				= $processNode->getAttribute('Id');
			$this->from				= $processNode->getAttribute('From');
			$this->to				= $processNode->getAttribute('To');
			
			$this->xpdlDefinition	= simplexml_import_dom($processNode)->asXML();
		}
		
		/**
		 * Obtщm id da Transiчуo
		 * @return string
		 */
		public function getId()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Id da Transiчуo "'.$this->id.'".');
			
			return $this->id;
		}
		
		/**
		 * Obtщm origem da Transiчуo
		 * @return string
		 */
		public function getFrom()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Id da Atividade origem da Transiчуo "'.$this->id.'".');
			
			return $this->from;
		}
		
		/**
		 * Obtщm Atividade de origem da Transiчуo
		 * @return WfContextActivity
		 */
		public function getActivityFrom()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Atividade origem da Transiчуo "'.$this->id.'".');
			
			return $this->process->getActivity($this->from);
		}
		
		/**
		 * Obtщm destino da Transiчуo
		 * @return string
		 */
		public function getTo()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Id da Atividade destino da Transiчуo "'.$this->id.'".');
			
			return $this->to;
		}
		
		/**
		 * Obtщm Atividade de destino da Transiчуo
		 * @return WfContextActivity
		 */
		public function getActivityTo()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Atividade destino da Transiчуo "'.$this->id.'".');
			
			return $this->process->getActivity($this->to);
		}
		
		/**
		 * Obtщm Processo que contщm a Transiчуo
		 * @return WfContextProcess
		 */
		public function getProcess()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Processo da Transiчуo "'.$this->id.'".');
			
			return $this->process;
		}
		
		/**
		 * Obtщm a definiчуo XPDL da Transiчуo
		 * @return string
		 */
		public function getXPDLDefinition()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo XPDL da Transiчуo "'.$this->id.'".');
			
			return $this->xpdlDefinition;
		}
	}
	
?>