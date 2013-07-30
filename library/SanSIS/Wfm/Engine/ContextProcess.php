<?php 
	
	/**
	 * Classe responsável por conter a interpretação do Processo
	 * do XPDL para utilização no contexto do processo em execução
	 * 
	 * @author Pablo Santiago Sánchez <phackwer@gmail.com>
	 * @version 1.0.0
	 * @package SanSIS_Wfm
	 * @subpackage Engine
	 *
	 */
	class SanSIS_Wfm_Engine_ContextProcess extends SanSIS_Wfm_Base
	{
		//atributos requeridos
		private $context;					//Contexto ao qual o Processo pertence
		private $id;						//id do Processo
		private $name;						//nome do Processo
		private $version;					//versão/data de criação do registro
		private $startEvent;				//evento de início
		private $endEvents		= array();	//eventos de fim (cancelamento/finalização)
		private $transitions	= array();	//lista de Participantes do Processo
		private $activities		= array();	//lista de Atividades contidas no Processo
		private $participants	= array();	//lista de Participantes do Processo
		private $dataobjects	= array();	//lista de DataObjects do Processo
		private $associations	= array();	//lista de Associações do Processo
		
		/**
		 * Construtor
		 * @param DOMElement $processNode
		 * @param WfContextData $context
		 */
		public function __construct(DOMElement $processNode, SanSIS_Wfm_Engine_ContextData $context)
		{
			$this->context			= $context;
			$this->id				= $processNode->getAttribute('Id');
			$this->name				= $processNode->getAttribute('Name');
			if ($processNode->getElementsByTagName('Created')->item(0))
				$this->version			= $processNode->getElementsByTagName('Created')->item(0)->nodeValue;
			
			SanSIS_Wfm_Debug_Debug::info('Mapeando Processo "'.$this->id.'" - "'.$this->name.'".');
					
			$this->xpdlDefinition	= simplexml_import_dom($processNode)->asXML();
			
			//transições devem ser processadas ANTES das atividades
			$this->processTransitions($processNode);
			$this->processActivities($processNode);
			
			SanSIS_Wfm_Debug_Debug::log('Processo "'.$this->id.'" - "'.$this->name.'" mapeado.');
		}	
		
		/**
		 * Processa as Transições presentes no Processo entre as Atividades
		 * As Transições são o que definem o caminho a ser seguido pelo Processo
		 * @param DOMElement $processNode
		 * @return void
		 */
		private function processTransitions(DOMElement $processNode)
		{
			$transitions = $processNode->getElementsByTagName('Transition');
			if ($transitions->length < 1)
				throw new SanSIS_Wfm_Exception_NoTransitionsOnXPDL();
				
			foreach ($transitions as $transition)
			{				
				$id = $transition->getAttribute('Id');
				$this->transitions[$id] = new SanSIS_Wfm_Engine_ContextTransition($transition, $this);
				
				SanSIS_Wfm_Debug_Debug::log('Transição "'.$id.'" associada ao Processo "'.$this->id.'" - "'.$this->name.'".');
			}
		}
		
		/**
		 * Processa as Atividades presentes no Processo, e suas Restrições de Transição
		 * @TODO - Tratar subfluxos nas atividades!
		 * @param DOMElement $processNode
		 * @return void
		 */
		private function processActivities(DOMElement $processNode)
		{
			$activities = $processNode->getElementsByTagName('Activity');
			if ($activities->length < 1)
				throw new SanSIS_Wfm_Exception_NoActivitiesOnXPDL();
				
			foreach ($activities as $activity)
			{
				$id = $activity->getAttribute('Id');
				$this->activities[$id] = new SanSIS_Wfm_Engine_ContextActivity($activity, $this);
				
				if ($this->activities[$id]->isStartEvent())
					$this->setStartEvent($this->activities[$id]);
					
				if ($this->activities[$id]->isEndEvent())
					$this->setEndEvents($this->activities[$id]);
				
				SanSIS_Wfm_Debug_Debug::log('Atividade "'.$id.'" associada ao Processo. "'.$this->id.'" - "'.$this->name.'".');
				
				$this->context->addActivity($this->activities[$id]);
			}
		}
		
		/**
		 * Adiciona um Participante do Contexto ao Processo
		 * @param string $id
		 * @return void
		 */
		public function addParticipant($id)
		{
			$this->participants[$id] = $this->context->getParticipant($id);
			
			SanSIS_Wfm_Debug_Debug::log('Participante "'.$id.'" associado ao Processo "'.$this->id.'" - "'.$this->name.'".');
			
			$this->participants[$id]->addProcess($this);
		}
		
		/**
		 * Obtém um Participante específico do Processo
		 * @param string $id
		 * @return WfContextParticipant
		 */
		public function getParticipant($id)
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Participante "'.$id.'" do Processo "'.$this->id.'" - "'.$this->name.'".');
			
			//verifica se existe participante			
			if (isset($this->participants[$id]))
				return $this->participants[$id];
			//se não existir lança exception
			else
				throw new SanSIS_Wfm_Exception_NoParticipantByThatId();
		}
		
		/**
		 * Obtém todos os Participantes do Processo
		 * @return array WfContextParticipant
		 */
		public function getParticipants()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Participantes do Processo "'.$this->id.'" - "'.$this->name.'".');
			
			return $this->participants;
		}
		
		/**
		 * Obtém uma Transição específica do Processo
		 * @param string $id
		 * @return WfContextTransition
		 */
		public function getTransition($id)
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Transição "'.$id.'" do Processo "'.$this->id.'" - "'.$this->name.'".');
			
			//verifica se existe participante			
			if (isset($this->transitions[$id]))
				return $this->transitions[$id];
			//se não existir lança exception
			else
				throw new SanSIS_Wfm_Exception_NoTransitionByThatId();
		}
		
		/**
		 * Obtém todas as Transições do Processo
		 * @return array WfContextTransition
		 */
		public function getTransitions()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Transições do Processo "'.$this->id.'" - "'.$this->name.'".');
			
			return $this->transitions;
		}
		
		/**
		 * Obtém todas as Transições do Processo
		 * @return array WfContextTransition
		 */
		public function getTransitionByOrigin($fromId)
		{			
			$return = array();
			
			foreach ($this->transitions as $transition)
			{
				if ($fromId == $transition->getFrom())
					$return[] = $transition;
			}
			
			return $return;
		}
		
		/**
		 * Obtém a primeira Atividade que inicia o processo
		 * @return WfContextActivity
		 */
		public function getStartEvent()
		{
			return $this->startEvent;
		}
		
		/**
		 * Define qual é a primeira Atividade que inicia o processo
		 * @param WfContextActivity $activity
		 * @return void
		 */
		public function setStartEvent(SanSIS_Wfm_Engine_ContextActivity $activity)
		{
			$this->startEvent = $activity;
		}
		
		/**
		 * Obtém as Atividades que podem por fim ao processo
		 * @return WfContextActivity
		 */
		public function getEndEvents()
		{
			return $this->endEvents;
		}
		
		/**
		 * Adiciona uma Atividade que pode por fim ao processo
		 * @param WfContextActivity $activity
		 * @return void
		 */
		public function setEndEvents(SanSIS_Wfm_Engine_ContextActivity $activity)
		{
			$this->endEvents[] = $activity;
		}
		
		/**
		 * Obtém as Atividades que podem por fim ao processo
		 * @return WfContextActivity
		 */
		public function getFinishEvents()
		{
			$finishEvents = array();
			foreach ($this->endEvents as $event)
			{
				if ($event->isFinishEvent())
					$finishEvents[] = $event;
			}
			return $finishEvents;
		}
	
		
		/**
		 * Obtém as Atividades que podem cancelar o processo
		 * @return WfContextActivity
		 */
		public function getCancelEvents()
		{
			$cancelEvents = array();
			foreach ($this->endEvents as $event)
			{
				if ($event->isCancelEvent())
					$cancelEvents[] = $event;
			}
			return $cancelEvents;
		}
		
		/**
		 * Obtém uma Atividade específica do Processo
		 * @param string $id
		 * @return WfContextActivity
		 */
		public function getActivity($id)
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Atividade "'.$id.'" do Processo "'.$this->id.'" - "'.$this->name.'".');
			
			//verifica se existe participante			
			if (isset($this->activities[$id]))
				return $this->activities[$id];
			//se não existir lança exception
			else
				throw new SanSIS_Wfm_Exception_NoActivityByThatId();
		}
		
		/**
		 * Obtém todas as Atividades do Processo
		 * @return array WfContextActivity
		 */
		public function getActivities()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Atividades do Processo "'.$this->id.'" - "'.$this->name.'".');
			
			return $this->activities;
		}
		
		/**
		 * Obtém Id do Processo
		 * @return string
		 */
		public function getId()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Id do Processo "'.$this->id.'" - "'.$this->name.'".');
			
			return $this->id;
		}
		
		/**
		 * Obtém Nome do Processo
		 * @return string
		 */
		public function getName()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Nome do Processo "'.$this->id.'" - "'.$this->name.'".');
			
			return $this->name;
		}
		
		/**
		 * Obtém Versão do Processo
		 * @return string
		 */
		public function getVersion()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Versão do Processo "'.$this->id.'" - "'.$this->name.'".');
			
			return $this->version;
		}
		
		/**
		 * Obtém Contexto que contém o Processo
		 * @return WfContextData
		 */
		public function getContext()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo Contexto do Processo "'.$this->id.'" - "'.$this->name.'".');
			
			return $this->context;
		}
		
		/**
		 * Obtém um Elemento qualquer por Id contidos no Contexto
		 * @param string $id
		 * @return array WfContextAssociation
		 */
		public function getElementById($id)
		{
			$element = null;
			
			try
			{
				$element = $this->getActivity($id);
			}
			catch (SanSIS_Wfm_Exception_Exception $e)
			{
				try
				{
					$element = $this->getParticipant($id);
				}
				catch (SanSIS_Wfm_Exception_Exception $e)
				{
						try
						{
							$element = $this->getTransition($id);
						}
						catch (SanSIS_Wfm_Exception_Exception $e)
						{
							throw new SanSIS_Wfm_Exception_NoElementByThatId();
						}						
				}
			}
			
			if (!$element)
				throw new SanSIS_Wfm_Exception_NoElementByThatId();
				
			
			return $element;
		}
		
		/**
		 * Obtém a definição XPDL do Processo
		 * @return string
		 */
		public function getXPDLDefinition()
		{
			SanSIS_Wfm_Debug_Debug::info('Obtendo XPDL do Processo "'.$this->id.'" - "'.$this->name.'".');
			
			return $this->xpdlDefinition;
		}
	}
	
?>