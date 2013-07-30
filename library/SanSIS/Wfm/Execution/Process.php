<?php

/**
 * Classe de 
 * 
 * @author Pablo Santiago Sсnchez <phackwer@gmail.com>
 * @version 1.0.0
 * @package SanSIS_Wfm
 * @subpackage Execution
 *
 */

class SanSIS_Wfm_Execution_Process extends SanSIS_Wfm_Execution_ExecutionObject {	
	protected $idExecutionObject;
	protected $idRequester;
	protected $idContextProcess;
	
	protected $executionObject;
	
	protected $activities = array ();
	
	public function __construct(SanSIS_Wfm_Engine_ContextData $context, SanSIS_Wfm_Engine_ContextProcess $structure, $name, $description, $idRequester) {
		$this->name               = $name;
		$this->description        = $description;
		$this->creationDate       = date ( 'Y/m/d h:i:s' );
		$this->idContext          = $context->getId();
		$this->idContextProcess   = $structure->getId();
		$this->context            = $context;
		$this->structure  		  = $structure;		
		$this->priority           = SanSIS_Wfm_Config_Environment::WF_PRIOR_NORMAL;
		$this->status             = SanSIS_Wfm_Config_Environment::WF_OPENED;
		$this->idRequester		  = $idRequester;
		
		$this->registerEvent(SanSIS_Wfm_Config_Environment::WF_EV_CREATION);
	}
	
	//mщtodos relacionados ao estado do Processo	
	public function setStarted() {
		$this->begin ();
		$startEvent = $this->structure->getStartEvent();
		$transitions = $this->structure->getTransitionByOrigin($startEvent->getId());
		
		foreach($transitions as $transition)
		{
			$act = $this->context->getActivity($transition->getTo());
			
			$activity = new SanSIS_Wfm_Execution_Activity(
				$act->getName(), 
				$act->getName(),
				$this->id,
				$act->getId(),
				$this->idContext
			);
			
			$this->activities[] = $activity;
		}
	}
	
	public function setEnded() {
		$this->endSuccess ();
	}
	
	public function setAborted() {
		$this->endAborted ();
	}
	
	public function setSuspended() {
		$this->suspend ();
	}
	
	//mщtodos para as atividades
	public function setActivities($acts_array) {
		$this->activities = $acts_array;
	}
	
	/**
	 * Funчуo responsсvel por ativar/desativar atividades
	 * do processo como atividades atuais
	 * @param string ou array $ids
	 */
	public function setCurrentActivities($ids)
	{
		//primeiro devemos marcar as atividades atuais como nуo sendo atuais
		$activities = $this->getCurrentActivities();
		foreach ($activities as $activity)
		{
			
		}
		//agora, verificamos se as atividades passadas jс nуo existem no sistema
		//se existirem, apenas atualizamos como atuais
		//se nуo, deveremos criar
	}
	
	//mщtodos relacionados ao solicitante
	public function setRequester($idRequester) {
		$this->idRequester = $idRequester;
	}
	public function getRequester() {
		return $this->idRequester;
	}
	
    //mщtodos relacionados aos dados do objeto
    public function setProcessData($object, $version = null) {
        //se informou versуo, carrega o grupo de dados daquela versуo
        /*****@TODO - nуo serс implantado ainda no SGD - nуo serс usado aqui
        mas deve ser implantado para poder usar a engine em outros sistemas posteriormente
        ******/
        if ($version)
        {
            
        }
        //se nуo informou
        else
        {
          //checa se existe algum grupo de versуo jс criado
          /*****@TODO - nуo serс implantado ainda no SGD - nуo serс usado aqui
          mas deve ser implantado para poder usar a engine em outros sistemas posteriormente
          o setProcessData sѓ щ chamado na criaчуo do processo no momento
          ******/
          //se nуo existe cria
          $datagroup = new SanSIS_Wfm_Execution_ProcessDataGroup($this->idExecutionObject);
        }
        //associa o objeto ao grupo de dados
        $datagroup->appendProcessData($object);
        //salva
        $datagroup->save();
    }
    public function getProcessData() {
    }
    public function getProcessDataByVersion($version) {
    }
    public function getAllProcessDataVersions() {
    }
    
    public function registerEvent($event, $newvalue = null, $oldvalue = null) {
        $event = SanSIS_Wfm_Event_EventAudit::newEvent($event, $this->idExecutionObject, $newvalue, $oldvalue);
        $this->events[] = $event;
    }
	
    public function save()
    {
        $this->executionObject = new SanSIS_Wfm_Execution_ExecutionObject();
        
        if ($this->id)
           	$this->executionObject->load($this->idExecutionObject);
        	
        //agora copiamos os atributos daqui para lс        
        foreach ($this->executionObject as $key=>$value)
        	if ($key != 'ormClass')
        		$this->executionObject->$key = $this->$key;
        	
        $this->executionObject->save();
        
        //e agora, e de lс para cс
        $this->idExecutionObject = $this->executionObject->getId();

        //salva no banco
        $this->ormSave();
        
        //aчѕes pѓs salvamento            
        $this->postSave();
    }
    
    public function postSave()
    {
        foreach ($this->activities as $activity)
        {
            $activity->idProcess = $this->id;
            $activity->save();
        }
        
        foreach ($this->data as $data)
        {
            $data->idExecutionObject = $this->idExecutionObject;
            $data->save();
        }
     }
}

?>