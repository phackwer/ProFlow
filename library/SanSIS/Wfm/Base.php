<?php 

    /**
     * Classe de base para o SanSIS_Wfm. Simplifica o uso de objetos externos
     * ao modelo para fins de ORM. 
     * 
     * @author Pablo Santiago Sánchez <phackwer@gmail.com>
     * @version 1.0.0
     * @package SanSIS_Wfm
     * @subpackage Execution
     *
     */
    
    abstract class SanSIS_Wfm_Base
    {
    	protected $xpdlDefinition;
    	
    	protected $ormClass;
    	
    	public function getOrmClass()
    	{
    		if (!isset($this->ormClass))
    		{
	    		$class          = strtolower(get_class($this));
	            $classname      = SanSIS_Wfm_Config_Environment::getConfig()->$class->class;
	            if ($classname)
	            	$this->ormClass = new $classname();
    		}
            return $this->ormClass;
    	}
    	
    	public function getMeta($attr)
    	{
    		$class = strtolower(get_class($this));
    		return SanSIS_Wfm_Config_Environment::getConfig()->$class->$attr;
    	}
        
        public function getReal($attr)
        {
            $class = strtolower(get_class($this));
            $attrs = SanSIS_Wfm_Config_Environment::getConfig()->$class;
            
            foreach($attrs as $mattr => $value)
                if ($mattr == $attr)
                    return $value;
                    
            return false;
        }
        
        public function __get($attr)
        {
            $mattr = $this->getMeta($attr);
            $orm = $this->getOrmClass();
            $this->$attr = $orm->$mattr;
            
            echo $orm->$mattr;  
            
            return $this->$attr;
        }
        
        public function __set($attr, $value)
        {
            $mattr = $this->getMeta($attr);
            $orm = $this->getOrmClass();
            $this->$attr = $value;
            if ($orm)
            	$orm->$mattr = $value;
        }
        
        public function load($id)
        {
        	$this->getOrmClass();
        	$this->ormClass->load($id);
                
            foreach ($this as $key=>$value)
                if ($attr = $this->getReal($key))
                {
                     $this->$key = $this->ormClass->$attr;
                }
        }
        
        public function ormSave()
        {	
            $this->getOrmClass();
                
            foreach ($this as $key=>$value)
            	if ($attr = $this->getReal($key))
                {
                     $this->ormClass->$attr = $value;
                }
                     
            $this->ormClass->save();
            $this->id = $this->ormClass->id;
        }
        
        public function postSave()
        {
        }
        
        public function save()
        {
            $this->ormSave();
            $this->postSave();
        }
        
        /**
         * Retorna um 
         * @return unknown_type
         */
        public function getExtAttr()
        {
        	if ($this->xpdlDefinition)
        	{
	        	//iniciamos a string como um objeto para manipulação
				$xpdl			= new DOMDocument();		
				$xpdl->loadXML(str_replace(array('xpdl:','xpdl2:', 'xpdExt:'), '', $this->xpdlDefinition));
				
				$extended = $xpdl->getElementsByTagName('ExtendedAttribute');
        	}
        	
        	return $extended; 
        }
    }