<?php 
    
    /**
     * Classe responsável por conter a interpretação da Atividade
     * do XPDL para utilização no contexto do processo em execução
     * 
     * @author Pablo Santiago Sánchez <phackwer@gmail.com>
     * @version 1.0.0
     * @package SanSIS_Wfm
     * @subpackage Engine
     * 
     * @TODO - Tratar subfluxos/atividades
     * @TODO - verificar implementation - No, Task (TaskUser, TaskManual, etc)
     * @TODO - verificar route - GatewayType
     * @TODO - verificar eventos (StartEvent, EndEvent, etc)
     * @TODO - verificar lógica de restrição (Inclusive, Parallel, Exclusive - sinônimos de AND e XOR e tem OR também!)
     *
     */
    class SanSIS_Wfm_Engine_ContextActivity extends SanSIS_Wfm_Base
    {
        //atributos requeridos
        private $process;                       //processo do qual a atividade faz parte
        private $id;                            //id da atividade
        private $name;                          //nome descritivo da atividade
        private $priority           = '';       //prioriedade da atividade
        private $type;                          //tipo da atividade (Implementation/Route/Block/Subflow/Tools)
        private $isStartEvent		= false;
        private $isEndEvent			= false;
        private $isFinishEvent		= false;
        private $isCancelEvent		= false;
        private $startMode          = '';       //modo de início
        private $finishMode         = '';       //modo de finalização
        private $performers         = array();  //participantes que realizam a atividade
        private $transitions        = array();  //transições que partem desta atividade (from)
        private $restrictions       = array(
                                    'join' => array(),
                                    'split' =>array()
                                    );          //restrições de transição
        
        /**
         * Construtor
         * @param DOMElement $processNode
         * @param WfContextProcess $process
         */
        public function __construct(DOMElement $processNode, SanSIS_Wfm_Engine_ContextProcess $process)
        {
            $this->process          = $process;
            $this->id               = $processNode->getAttribute('Id');
            $this->name             = $processNode->getAttribute('Name');
            
            SanSIS_Wfm_Debug_Debug::info('Mapeando Atividade "'.$this->id.'" - "'.$this->name.'".');
            
            $priority = $processNode->getElementsByTagName('Priority');
            if ($priority->length == 1)
                $this->priority     = $priority->item(0)->nodeValue;
            
            //(No implementation/Route/Block/Subflow/Tools)
            //tipos
            $block                  = $processNode->getElementsByTagName('BlockActivity')	->length;
            $imp                    = $processNode->getElementsByTagName('Implementation')	->length;
            $route                  = $processNode->getElementsByTagName('Route')			->length;
            $sub                    = $processNode->getElementsByTagName('Subflow')			->length;

            //verifica tipo
            //BlockActivity
            if ($block)
                $this->type         = 'BlockActivity';
            //Implementation
            if ($imp)
                $this->type         = 'Implementation';
            //Route
            if ($route)
                $this->type         = 'Route';
            //Subflow
            if ($sub)
                $this->type         = 'Subflow';
            
            $startMode = $processNode->getElementsByTagName('StartMode');
            if ($startMode->length == 1)
            {
                $mode = $startMode->item(0)->getElementsByTagName('Automatic');
                
                if ($mode->length == 1)
                    $this->startMode = 'Automatic';
                else
                    $this->startMode = 'Manual'; 
            }
            
            $finishMode = $processNode->getElementsByTagName('FinishMode');
            if ($finishMode->length == 1)
            {
                $mode = $finishMode->item(0)->getElementsByTagName('Automatic');
                
                if ($mode->length == 1)
                    $this->finishMode = 'Automatic';
                else
                    $this->finishMode = 'Manual'; 
            }
            
            if ($processNode->getElementsByTagName('StartEvent')->length)
				$this->isStartEvent		= true;
			if ($processNode->getElementsByTagName('EndEvent')->length)
			{
				$this->isEndEvent		= true;
				
				$end = $processNode->getElementsByTagName('EndEvent');
				
				if ($end->item(0)->getAttribute('Result') == 'None')
					$this->isCancelEvent	= true;
				else if ($end->item(0)->getAttribute('Result') == 'Terminate')
					$this->isFinishEvent	= true;
				
			}
            
            $this->xpdlDefinition   = simplexml_import_dom($processNode)->asXML();
            
            $this->processPerformers($processNode);
            $this->processTransitions();
            $this->processTransitionRestrictions($processNode);
            
            SanSIS_Wfm_Debug_Debug::log('Atividade "'.$this->id.'" - "'.$this->name.'" mapeada.');
        }
        
        public function isStartEvent()
        {
        	return $this->isStartEvent;
        }
        
        public function isEndEvent()
        {
        	return $this->isEndEvent;
        }
        
        public function isFinishEvent()
        {
        	return $this->isFinishEvent;
        }
        
        public function isCancelEvent()
        {
        	return $this->isCancelEvent;
        }
        
        /**
         * Processa os executores permitidos para esta atividade
         * @param DOMElement $processNode
         * @return void
         */
        private function processPerformers(DOMElement $processNode)
        {
            $performers     = $processNode->getElementsByTagName('Performer');
            $startevent     = $processNode->getElementsByTagName('StartEvent');
            $endevent       = $processNode->getElementsByTagName('EndEvent');
                
            foreach ($performers as $performer)
            {
                $id = $performer->nodeValue;
                $this->performers[$id] = $this->process->getContext()->getParticipant($id);
                $this->process->addParticipant($id);
                
                SanSIS_Wfm_Debug_Debug::log('Executor "'.$id.'" associado à Atividade "'.$this->id.'" - "'.$this->name.'".');
            }
        }
        
        /**
         * Processa as transições que partem desta atividade
         * @return void
         */
        private function processTransitions()
        {
            $transitions = $this->process->getTransitions();
            if (count($transitions) < 1)
                throw new SanSIS_Wfm_Exception_NoTransitionsOnXPDL();
                
            foreach ($transitions as $transition)
                if ($this->id == $transition->getFrom())
                {
                    $id = $transition->getId('Id');
                    $this->transitions[$id] = $transition;
                    
                    SanSIS_Wfm_Debug_Debug::log('Transição "'.$id.'" associada à Atividade "'.$this->id.'" - "'.$this->name.'".');
                }
        }
        
        /**
         * Processa as restrições que as transições de e para esta atividade sofrem
         * @param DOMElement $processNode
         * @return void
         */
        private function processTransitionRestrictions(DOMElement $processNode)
        {
            $restrictions = $processNode->getElementsByTagName('TransitionRestriction');
            if ($restrictions->length >= 1)
            {
                foreach ($restrictions as $restriction)
                {
                    $split = $restriction->getElementsByTagName('Split');
                    $join  = $restriction->getElementsByTagName('Join');
                    
                    if ($split->length == 1)
                    {
                        $type = 'Split';
                        $logic = $split->item(0)->getAttribute('Type');
                        $new_rest = new SanSIS_Wfm_Engine_ContextRestriction($split->item(0), $type, $logic);

                        $transitions = $split->item(0)->getElementsByTagName('TransitionRef');
                        
                        foreach ($transitions as $transition)
                            $new_rest->addTransition($this->transitions[$transition->getAttribute('Id')]);
                            
                        $this->restrictions[] = $new_rest;
                        
                        SanSIS_Wfm_Debug_Debug::log('Restrição do tipo '.$type.' com lógica '.$logic.' associada à Atividade "'.$this->id.'" - "'.$this->name.'".');
                    }
                    
                    if ($join->length == 1)
                    {
                        $type = 'Join';
                        $logic = $join->item(0)->getAttribute('Type');
                        $new_rest = new SanSIS_Wfm_Engine_ContextRestriction($join->item(0), $type, $logic);
                        
                        $this->restrictions[] = $new_rest;
                        
                        SanSIS_Wfm_Debug_Debug::log('Restrição do tipo '.$type.' com lógica '.$logic.' associada à Atividade "'.$this->id.'" - "'.$this->name.'".');
                    }
                }
            }
        }
        
        /**
         * Obtem um array com as próximas atividades, ou falso se não houver atividade subsequente
         * @return array WfContextActivity
         */
        public function getNextActivities()
        {
            $activities = array();
            
            foreach ($this->transitions as $transition)
            {
                $id = $transition->getTo();
                $activities[$id] = $this->process->getActivity($transition->getTo());
            }
            
            SanSIS_Wfm_Debug_Debug::info('Obtendo próximas Atividades de "'.$this->id.'" - "'.$this->name.'".');
            
            if (!count($activities))
            {
                SanSIS_Wfm_Debug_Debug::error('"'.$this->id.'" - "'.$this->name.'" não possue Atividades subseqüentes.');
                
                return false;
            }

            return $activities;
        }
        
        /**
         * Checa se tem restrições de transição
         * @return bool
         */
        public function hasRestrictions()
        {
            SanSIS_Wfm_Debug_Debug::info('Checando Atividade "'.$this->id.'" - "'.$this->name.'" por Restrições.');
            
            return count($this->restriction);
        }
        
        /**
         * Checa se tem restrições do tipo split, aplicadas exclusivamente na saída para outra atividade
         * @return bool
         */
        public function hasSplitRestrictions()
        {
            SanSIS_Wfm_Debug_Debug::info('Checando Atividade "'.$this->id.'" - "'.$this->name.'" por Restrições de Split.');
            
            $has = false;
            
            foreach ($this->restrictions as $restriction)
                if ($restriction->getType == 'Split')
                    $has = true;
            
            return $has;
        }    
        
        /**
         * Checa se tem restrições do tipo join, aplicadas exclusivamente na entrada vindo de outra atividade
         * @return bool
         */
        public function hasJoinRestrictions()
        {
            SanSIS_Wfm_Debug_Debug::info('Checando Atividade "'.$this->id.'" - "'.$this->name.'" por Restrições de Join.');
            
            $has = false;
            
            foreach ($this->restrictions as $restriction)
                if ($restriction->getType == 'Join')
                    $has = true;
            
            return $has;
        }
        
        /**
         * Obtém o processo de uma atividade
         * @return WfContextProcess
         */
        public function getProcess()
        {
            SanSIS_Wfm_Debug_Debug::info('Obtendo Processo da Atividade "'.$this->id.'" - "'.$this->name.'".');
            
            return $this->process;
        }
        
        /**
         * Obtém Id da Atividade
         * @return string
         */
        public function getId()
        {
            SanSIS_Wfm_Debug_Debug::info('Obtendo Id da Atividade "'.$this->id.'" - "'.$this->name.'".');
            
            return $this->id;
        }
        
        /**
         * Obtém Nome da Atividade
         * @return string
         */
        public function getName()
        {
            SanSIS_Wfm_Debug_Debug::info('Obtendo Nome da Atividade "'.$this->id.'" - "'.$this->name.'".');
            
            return $this->name;
        }
        
        /**
         * Obtém Prioridade da Atividade
         * @return string
         */
        public function getPriority()
        {
            SanSIS_Wfm_Debug_Debug::info('Obtendo Prioridade da Atividade "'.$this->id.'" - "'.$this->name.'".');
            
            return $this->priority;
        }
        
        /**
         * Obtém o Tipo da Atividade
         * @return string
         */
        public function getType()
        {
            SanSIS_Wfm_Debug_Debug::info('Obtendo Tipo da Atividade "'.$this->id.'" - "'.$this->name.'".');
            
            return $this->type;
        }
        
        /**
         * Obtém o Modo de Início da Atividade
         * @return string
         */
        public function getStartMode()
        {
            SanSIS_Wfm_Debug_Debug::info('Obtendo StartMode da Atividade "'.$this->id.'" - "'.$this->name.'".');
            
            return $this->startMode;
        }
        
        /**
         * Obtém o Modo de Finalização da Atividade
         * @return string
         */
        public function getFinishMode()
        {
            SanSIS_Wfm_Debug_Debug::info('Obtendo FinishMode da Atividade "'.$this->id.'" - "'.$this->name.'".');
            
            return $this->finishMode;
        }
        
        /**
         * Obtém o Executor de uma Atividade
         * @param string $id
         * @return WfContextParticipant
         */
        public function getPerformer($id)
        {
            SanSIS_Wfm_Debug_Debug::info('Obtendo Executor "'.$id.'" da Atividade "'.$this->id.'" - "'.$this->name.'".');
            
            //verifica se existe participante            
            if (isset($this->performers[$id]))
                return $this->performers[$id];
            //se não existir lança exception
            else
                throw new SanSIS_Wfm_Exception_NoParticipantByThatId();
        }
        
        /**
         * Obtém todos os Executores contidos na Atividade
         * @return array WfContextParticipant
         */
        public function getPerformers()
        {
            SanSIS_Wfm_Debug_Debug::info('Obtendo Executores da Atividade "'.$this->id.'" - "'.$this->name.'".');
            
            return $this->performers;
        }
        
        /**
         * Obtém uma Transição específica da Atividade
         * @param string $id
         * @return WfContextTransition
         */
        public function getTransition($id)
        {
            SanSIS_Wfm_Debug_Debug::info('Obtendo Transição "'.$id.'" da Atividade "'.$this->id.'" - "'.$this->name.'".');
            
            //verifica se existe participante            
            if (isset($this->transitions[$id]))
                return $this->transitions[$id];
            //se não existir lança exception
            else
                throw new SanSIS_Wfm_Exception_NoTransitionByThatId();
        }
        
        /**
         * Obtém todas as Transições da Atividade
         * @return array WfContextTransition
         */
        public function getTransitions()
        {
            SanSIS_Wfm_Debug_Debug::info('Obtendo Transições da Atividade "'.$this->id.'" - "'.$this->name.'".');
            
            return $this->transitions;
        }
        
        /**
         * Obtém todas as Restrições de Transição contidas na Atividade
         * @return array WfContextRestriction
         */
        public function getRestrictions()
        {
            SanSIS_Wfm_Debug_Debug::info('Obtendo Restrições da Atividade "'.$this->id.'" - "'.$this->name.'".');
            
            return $this->restrictions;
        }
        
        /**
         * Obtém a definição XPDL do Contexto
         * @return string XML
         */
        public function getXPDLDefinition()
        {
            SanSIS_Wfm_Debug_Debug::info('Obtendo XPDL da Atividade "'.$this->id.'" - "'.$this->name.'".');
            
            return $this->xpdlDefinition;
        }
    }

?>