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

	class SanSIS_Wfm_Execution_ProcessData extends SanSIS_Wfm_Base
	{
		protected $id;
        protected $idProcessDataGroup;
        protected $idExternal;
        protected $externalClass;
        
        public function setDataObject($object)
        {
        	$this->idExternal = $object->id;
        	$this->externalClass = get_class($object);
        }
	}

?>