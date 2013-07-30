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

class SanSIS_Wfm_Execution_Activity extends SanSIS_Wfm_Execution_ExecutionObject
{
	protected $idExecutionObject;
	protected $idProcess;
	protected $idContextActivity;
	
	protected $current = 1;
	
	protected $executionObject;
	
	public function __construct(
		$name						= null, 
		$description				= null,
		$idProcess					= null,
		$idContextActivity			= null,
		$idContext					= null
	)
	{
		$this->name					= $name;
		$this->description			= $description;
		$this->idProcess			= $idProcess;
		$this->idContextActivity 	= $idContextActivity;
		$this->idContext			= $idContext;
		
		$this->creationDate			= date('Y-m-d h:m:i');
		$this->status				= 1;
	}
	
	public function save()
    {
        $this->executionObject = new SanSIS_Wfm_Execution_ExecutionObject();
        
        if ($this->id)
           	$this->executionObject->load($this->idExecutionObject);
        	
        //agora copiamos os atributos daqui para lá        
        foreach ($this->executionObject as $key=>$value)
        	if ($key != 'ormClass')
        		$this->executionObject->$key = $this->$key;
       	
        $this->executionObject->save();      
        
        $this->executionObject->save();
        
        //e agora, e de lá para cá
        $this->idExecutionObject = $this->executionObject->getId();

        //salva no banco
        $this->ormSave();
        
        //ações pós salvamento            
        $this->postSave();
    }
    
    public function getExtAttr()
    {
    	$contextactivity = $this->getContextData()->getActivity($this->idContextActivity);
    	return $contextactivity->getExtAttr();
    }
}

?>