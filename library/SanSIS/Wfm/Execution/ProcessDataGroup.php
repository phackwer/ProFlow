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

	class SanSIS_Wfm_Execution_ProcessDataGroup extends SanSIS_Wfm_Base
	{
		protected $id;
        protected $idExecutionObject;
        protected $version;
        
        protected $data = array();
        
        public function __construct($idExecutionObject, $version = 1)
        {
        	$this->idExecutionObject   = $idExecutionObject;
        	$this->version             = $version;
        }
        
        public function appendProcessData($object)
        {
            $data = new SanSIS_Wfm_Execution_ProcessData();
            $data->setDataObject($object);
            
            $this->data[] = $data;
        }
        
	    public function postSave()
        {
	        foreach ($this->data as $data)
	        {
	            $data->idProcessDataGroup = $this->ormClass->id;
	            $data->save();
	        }
        }
	}

?>