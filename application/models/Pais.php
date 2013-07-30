<?php

/**
 * Modelo para regras de negócio referentes ao país
 *
 * @package		ProFlow
 * @subpackage	models
 * @category	Model
 * @name		Pais
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */

class ProFlow_Model_Pais extends ProFlow_Model_DbTable_Pais
{
	public function getList($params = null)
	{
		if (!isset($params['status_tupla']))
			$where = 'status_tupla = \'1\'';
		else
			$where = 'status_tupla = \''.$params['status_tupla'].'\'';
		
		if (isset($params['nome']) && $params['nome'])
			$where .= ' and nome ILIKE \'%'.str_replace(' ', '%', $params['nome']).'%\'';
		
		$orderby = 'nome ASC';
		
		return $this->getAll($where, $orderby, null, null, 'array');
	}
}

