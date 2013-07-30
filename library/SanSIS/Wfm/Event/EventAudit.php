<?php 

    /**
     * Classe de evento
     * 
     * @author Pablo Santiago Sánchez <phackwer@gmail.com>
     * @version 1.0.0
     * @package SanSIS_Wfm
     * @subpackage Event
     *
     */

    abstract class SanSIS_Wfm_Event_EventAudit extends SanSIS_Wfm_Base
    {
    	protected $id;
    	protected $timeStamp;
    	protected $eventType;
    	protected $oldValue;
    	protected $newValue;
    	protected $idExecutionObject;
    	
    	public function __construct($idExecutionObject, $newvalue = null, $oldvalue = null)
    	{
    		$this->oldValue           = $oldvalue;
    		$this->newValue           = $newvalue;
    		$this->timeStamp          = date('Y-m-d h:i:s');
    		$this->idExecutionObject  = $idExecutionObject;
    		
    		if ($this->idExecutionObject)
    		  $this->save();
    	}
    	
    	public function newEvent($event, $idExecutionObject, $newvalue = null, $oldvalue = null)
    	{
    		//constantes para tipos de eventos
    		switch($event)
    		{
    			case SanSIS_Wfm_Config_Environment::WF_EV_CREATION:
    				$newEvent = new SanSIS_Wfm_Event_EventAuditCreateProcess($idExecutionObject, $newvalue, $oldvalue);
    				break;
    			case SanSIS_Wfm_Config_Environment::WF_EV_ASSIGN:
    				$newEvent = new SanSIS_Wfm_Event_EventAuditAssignment($idExecutionObject, $newvalue, $oldvalue);
    				break;
		        case SanSIS_Wfm_Config_Environment::WF_EV_STATE:
		        	$newEvent = new SanSIS_Wfm_Event_EventAuditState($idExecutionObject, $newvalue, $oldvalue);
		        	break;
		        case SanSIS_Wfm_Config_Environment::WF_EV_DATA:
		        	$newEvent = new SanSIS_Wfm_Event_EventAuditData($idExecutionObject, $newvalue, $oldvalue);
		        	break;
		        case SanSIS_Wfm_Config_Environment::WF_EV_END:
		        	$newEvent = new SanSIS_Wfm_Event_EventAuditState($idExecutionObject, $newvalue, $oldvalue);
		        	break;
		        default:
		        	throw new SanSIS_Wfm_Exception_NoEventByThatId();
    		}
    		
    		return $newEvent;
    	}
    }

?>