<?php

class SanSIS_Validate_Datetime extends Zend_Validate_Abstract
{
	const DATETIME_INVALID = "date_invalid";
	
	protected $_messageTemplates = array (
		self::DATETIME_INVALID => "Data/hora inválida"
	);

	public function isValid($value)
	{
		$valid = true;
		
		$dateValidator = new Zend_Validate_Date('dd/MM/yyyy hh:ii');
		$valid = $dateValidator->isValid($value);
		
		$values = $this->breakDate($value);
		
		if(isset($values['time'])){
			if ((!isset($values['time'][0]) && !isset($values['time'][1])) || $values['time'][0] > 24 || $values['time'][1] > 59 ||(isset($values['time'][2]) && $values['time'][2] > 59))
			{
				$this->_error(self::DATETIME_INVALID);
				return  false;
			}
		}
	
		return true;
	}
	
	public function breakDate($value)
	{
		$return = array();
		
		$value = explode(' ', $value);
		
		$return['date'] = explode ('/', $value[0]);
		if(count($value)>1){
			$return['time'] = explode (':', $value[1]);
		}
	
		return $return;
	}
	
	public function getAbsValue($value)
	{
		$values = $this->breakDate($value);
		return 		$values['date'][2].
					$values['date'][1].
					$values['date'][0].
					$values['time'][0].
					$values['time'][1];
	}
}