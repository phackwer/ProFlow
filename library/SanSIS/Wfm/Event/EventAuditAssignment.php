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

	class SanSIS_Wfm_Event_EventAuditAssignment extends SanSIS_Wfm_Event_EventAudit
	{
		protected $eventType = SanSIS_Wfm_Config_Environment::WF_EV_ASSIGN;
	}

?>