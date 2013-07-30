<?php 
	
	/**
	 * Classe responsсvel por definir as Associaчѕes
	 * do XPDL para utilizaчуo no contexto do processo em execuчуo
	 * 
	 * @author Pablo Santiago Sсnchez <phackwer@gmail.com>
	 * @version 1.0.0
	 * @package SanSIS_Wfm
	 * @subpackage Engine
	 *
	 */
	class SanSIS_Wfm_Engine_ContextAssociation extends SanSIS_Wfm_Base
	{
		//atributos requeridos
		private $context;				//Contexto ao qual a Associaчуo pertence
		private $id;					//id
		private $name;					//nome
		private $source;				//origem
		private $target;				//destino
		
		/**
		 * Construtor
		 * @param DOMElement $processNode
		 * @param string $type
		 * @param string $logic
		 */
		public function __construct(DOMElement $processNode, SanSIS_Wfm_Engine_ContextData $context)
		{
			SanSIS_Wfm_Debug_Debug::info('Mapeando Associaчуo.');
			
			$this->context			= $context;
			$this->id				= $processNode->getAttribute('Id');
			$this->name				= $processNode->getAttribute('Name');
			
			//busca atividade, objecto de dados ou associaчуo como origem da associaчуo
			$this->setSource($this->context->getElementById($processNode->getAttribute('Source')));
			//busca atividade, objecto de dados ou associaчуo como destino da associaчуo
			$this->setTarget($this->context->getElementById($processNode->getAttribute('Target')))   ;
			
			$this->xpdlDefinition	= simplexml_import_dom($processNode)->asXML();
			
			SanSIS_Wfm_Debug_Debug::log('Associaчуo mapeada.');
		}
		
		/**
		 * Define um objeto da Wf como source da Associaчуo
		 * @param WfContextTransition $transition
		 * @return void
		 */
		public function setSource($source)
		{
			$id = $source->getId();
			$this->source = $source;
			
			SanSIS_Wfm_Debug_Debug::log('Objeto "'.$id.'" definido como source da Associaчуo.');
		}

		/**
		 * Define um objeto da Wf como target da Associaчуo
		 * @param WfContextTransition $transition
		 * @return void
		 */
		public function setTarget($target)
		{
			$id = $target->getId();
			$this->target = $target;
			
			SanSIS_Wfm_Debug_Debug::log('Objeto "'.$id.'" definido como target da Associaчуo.');
		}
		
		/**
		 * Obtщm um objeto da Wf como source da Associaчуo
		 * @return Object
		 */
		public function getSource()
		{
			SanSIS_Wfm_Debug_Debug::log('Obtendo Objeto source "'.$id.'" da Associaчуo.');
			
			return $this->source = $source;
		}

		/**
		 * Obtщm um objeto da Wf como target da Associaчуo
		 * @return Object
		 */
		public function getTarget()
		{			
			SanSIS_Wfm_Debug_Debug::log('Obtendo Objeto target "'.$id.'" da Associaчуo.');
			
			return $this->target = $source;
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