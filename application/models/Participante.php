<?php

/**
 * Modelo para regras de negócio referentes ao participante
 *
 * @package		ProFlow
 * @subpackage	models
 * @category	Model
 * @name		Participante
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */

class ProFlow_Model_Participante extends ProFlow_Model_DbTable_Participante
{
	public function getList($params = null)
	{
		if (!isset($params['status_tupla']))
			$where = 'status_tupla = \'1\'';
		else
			$where = 'status_tupla = \''.$params['status_tupla'].'\'';
		
		if (isset($params['nome']) && $params['nome'])
			$where .= ' and nome ILIKE \'%'.str_replace(' ', '%', $params['nome']).'%\'';
		
		if (isset($params['descricao']) && $params['descricao'])
			$where .= ' and descricao ILIKE \'%'.str_replace(' ', '%', $params['descricao']).'%\'';
		
		$orderby = 'nome ASC';
		
		return $this->getAll($where, $orderby, null, null, 'array');
	}
}

