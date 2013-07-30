<?php

class SanSIS_Validate_DatetimeMustBeAfterNow extends SanSIS_Validate_Datetime
{
	const DATETIME_INVALID = "date_invalid";
	
	protected $_messageTemplates = array (
		self::DATETIME_INVALID => "Data/hora não pode estar no passado para este campo"
	);

	public function isValid($value)
	{
		$compare = $this->getAbsValue($value);
		
		if ($compare > date('YmdHi'))
	  		return true;
		else
		{
			$this->_error(self::DATETIME_INVALID);
			return false;
		}
	}
}