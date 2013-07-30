<?php 
	
	/**
	 * Classe responsсvel por conter a Retriчуo de Transiчуo da Atividade
	 * do XPDL para utilizaчуo no contexto do processo em execuчуo
	 * 
	 * @author Pablo Santiago Sсnchez <phackwer@gmail.com>
	 * @version 1.0.0
	 * @package SanSIS_Wfm
	 * @subpackage Engine
	 *
	 */
	class SanSIS_Wfm_Engine_ContextRestriction extends SanSIS_Wfm_Base
	{
		//atributos requeridos
		private $type;					//Split ou Join
		private $logic;					//XOR ou AND
		private $appliesTo	= array();	//Transiчѕes ao qual щ aplicado
		
		/**
		 * Construtor
		 * @param DOMElement $processNode
		 * @param string $type
		 * @param string $logic
		 */
		public function __construct(DOMElement $processNode, $type, $logic)
		{
			SanSIS_Wfm_Debug_Debug::info('Mapeando Restriчуo.');
			
			$this->type = $type;
			$this->logic = $logic;
			
			$this->xpdlDefinition	= simplexml_import_dom($processNode)->asXML();
			
			SanSIS_Wfm_Debug_Debug::log('Restriчуo mapeada.');
		}

		/**
		 * Adiciona uma Transiчуo р qual a Restriчуo faz referъncia
		 * @param WfContextTransition $transition
		 * @return void
		 */
		public function addTransition(SanSIS_Wfm_Engine_ContextTransition $transition)
		{
			$id = $transition->getId();
			$this->appliesTo[$id] = $transition;
			
			SanSIS_Wfm_Debug_Debug::log('Transiчуo "'.$id.'" associada р Restriчуo.');
		}
		
		/**
		 * Obtщm as Transiчѕes рs quais a Restriчуo щ aplicada 
		 * @return array WfContextTransition
		 */
		public function getTransitions()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Transiчѕes рs quais a Restriчуo щ aplicada.');
			
			return $this->appliesTo;
		}
		
		/**
		 * Obtщm o Tipo da Restriчуo (Split/Join)
		 * @return string
		 */
		public function getType()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Tipo da Restriчуo.');
			
			return $this->type;	
		}
		
		/**
		 * Obtщm a Lѓgica da Restriчуo (AND/XOR)
		 * @return string
		 */
		public function getLogic()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Lѓgica da Restriчуo.');
			
			return $this->logic;
		}
		
		/**
		 * Obtщm a definiчуo XPDL do Contexto
		 * @return string
		 */
		public function getXPDLDefinition()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo XPDL da Restriчуo.');
			
			return $this->xpdlDefinition;
		}
	}
	
?>