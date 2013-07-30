<?php 
	
	/**
	 * Classe responsсvel por definir os DataObjects, que servem de apoio
	 * ao controle do fluxo do processo, checando a entrada de objetos de dados
	 * e seus respectivos estados
	 * 
	 * @author Pablo Santiago Sсnchez <phackwer@gmail.com>
	 * @version 1.0.0
	 * @package SanSIS_Wfm
	 * @subpackage Engine
	 *
	 */
	class SanSIS_Wfm_Engine_ContextDataObject extends SanSIS_Wfm_Base
	{
		//atributos requeridos
		private $context;				//Processo ao qual o DataObject pertence
		private $id;					//id
		private $name;					//nome da classe do DataObject
		private $status;					//estado em que o objeto se encontra
		
		/**
		 * Construtor
		 * @param DOMElement $processNode
		 */
		public function __construct(DOMElement $processNode, SanSIS_Wfm_Engine_ContextData $context)
		{
			SanSIS_Wfm_Debug_Debug::info('Mapeando Objeto de Dados.');
			
			$this->context			= $context;
			$this->id				= $processNode->getAttribute('Id');
			$this->name				= $processNode->getAttribute('Name');
			
			$dataobject				= $processNode->getElementsByTagName('DataObject');
			$this->status			= $dataobject->item(0)->getAttribute('State');
			
			$this->xpdlDefinition	= simplexml_import_dom($processNode)->asXML();
			
			SanSIS_Wfm_Debug_Debug::log('Objeto de Dados mapeado.');
		}
		
		/**
		 * Obtщm Id do Objeto de Dados
		 * @return string
		 */
		public function getId()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Id do Objeto de Dados "'.$this->id.'" - "'.$this->name.'".');
			
			return $this->id;
		}
		
		/**
		 * Obtщm Nome do Objeto de Dados
		 * @return string
		 */
		public function getName()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Nome do Objeto de Dados "'.$this->id.'" - "'.$this->name.'".');
			
			return $this->name;
		}
		
		/**
		 * Obtщm Nome do Objeto de Dados
		 * @return string
		 */
		public function getState()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Estado do Objeto de Dados "'.$this->id.'" - "'.$this->name.'".');
			
			return $this->status;
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