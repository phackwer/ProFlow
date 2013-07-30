<?php

class SanSIS_Validate_HtmlStringLength extends Zend_Validate_StringLength
{
	public function isValid($value)
	{
		return parent::isValid(strip_tags($value));
	}
}