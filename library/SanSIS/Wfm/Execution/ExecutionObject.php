<?php

/**
 * Classe de 
 * 
 * @author Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version 1.0.0
 * @package SanSIS_Wfm
 * @subpackage Execution
 *
 */

class SanSIS_Wfm_Execution_ExecutionObject extends SanSIS_Wfm_Base {
	//atributos requeridos para persistência
	protected $id;
	protected $name;
	protected $description;
	protected $priority = 0;
	protected $status;
	protected $completion = 0;
	protected $creationDate;
	protected $startDate;
	protected $endDate;
	protected $idContext;
	
	protected $context;
	protected $structure;
	
	protected $data    = array();
	protected $events  = array();
	
	//métodos relacionados a atributos
	public function getId() {
		return $this->id;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	public function getName() {
		return $this->name;
	}
	public function setDescription($description) {
		$this->description = $description;
	}
	public function getDescription() {
		return $this->description;
	}
	//métodos relacionados à prioridade
	public function setPriority($priority) {
		$this->priority = $priority;
	}
	public function getPriority() {
		return $this->priority;
	}
	
	//métodos relacionados ao contexto
	public function setContextData(SanSIS_Wfm_Engine_ContextProcess $context) {
		$this->context = $context;
		$this->idContext = $context->getId();
	}
	public function getContextData() {
		return $this->context;
	}
	
	//métodos relacionados ao estado
	public function setState($status) {
		$this->registerEvent(SanSIS_Wfm_Config_Environment::WF_EV_STATE, $status, $this->status);
		$this->status = $status;
	}
	public function getState() {
		return $this->status;
	}
	
	public function begin() {
		$this->completion = 0;
		$this->startDate = date ( 'Y/m/d h:i:s' );
		$this->setState ( SanSIS_Wfm_Config_Environment::WF_STARTED );
	}
	public function suspend() {
		$this->setState ( SanSIS_Wfm_Config_Environment::WF_SUSPENDED );
	}
	public function endSuccess() {
		$this->completion = 100;
		$this->endDate = date ( 'Y/m/d h:i:s' );
		$this->setState ( SanSIS_Wfm_Config_Environment::WF_ENDED );
	}
	public function endAborted() {
		$this->completion = 100;
		$this->endDate = date ( 'Y/m/d h:i:s' );
		$this->setState ( SanSIS_Wfm_Config_Environment::WF_ABORTED );
	}
	
	//métodos relacionados à complitude
	public function setCompletion($completion) {
		$this->completion = $completion;
	}
	public function getCompletion() {
		return $this->completion;
	}
	
	//métodos relacionados à datas-chave do objeto
	public function getCreationDate() {
		return $this->creationDate;
	}
	public function getStartDate() {
		return $this->startDate;
	}
	public function getEndDate() {
		return $this->endDate;
	}
	
	//métodos relacionados a eventos
	public function getEventsHistory() {
		return $this->events;
	}
	public function registerEvent($event, $newvalue = null, $oldvalue = null) {
		$event = SanSIS_Wfm_Event_EventAudit::newEvent($event, $this->id, $newvalue, $oldvalue);
		$this->events[] = $event;
	}
	
    public function postSave()
    {        
        foreach ($this->events as $event)
        {
        	$event->idExecutionObject = $this->id;
            $event->save();
        }
    }
}

?>