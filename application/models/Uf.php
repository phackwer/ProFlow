<?php

/**
 * Modelo para regras de negócio referentes à UF
 *
 * @package		ProFlow
 * @subpackage	models
 * @category	Model
 * @name		Uf
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */

class ProFlow_Model_Uf extends ProFlow_Model_DbTable_Uf
{
	public function getList($params = null)
	{
		if (!isset($params['status_tupla']))
			$where = 'uf.status_tupla = \'1\'';
		else
			$where = 'uf.status_tupla = \''.$params['status_tupla'].'\'';
			
		$where .= ' and pais.status_tupla = \'1\'';
		
		if (isset($params['sigla']) && $params['sigla'])
			$where .= ' and uf.sigla ILIKE \'%'.str_replace(' ', '%', $params['sigla']).'%\'';
		
		if (isset($params['nome']) && $params['nome'])
			$where .= ' and uf.nome ILIKE \'%'.str_replace(' ', '%', $params['nome']).'%\'';
			
		if (isset($params['id_pais']) && $params['id_pais'])
			$where .= ' and uf.id_pais = '.$params['id_pais'];
		
		$order = array(
			'uf.nome' , 
			'pais.nome ASC'
		);
		
		$select = $this->select()
			->setIntegrityCheck(false)
			->from(array('uf' => 'public.uf'), array(
				'id' 		=> 'uf.id',
				'nome' 		=> 'uf.nome',
				'sigla' 	=> 'uf.sigla',
			)
		)
		->join(array('pais' => 'public.pais'), 'uf.id_pais = pais.id', array(
			'país' => 'pais.nome'
		))
		->where($where)
		->order($order);
			
		//echo $select->assemble(); die; 
			
		return $this->getAll($select, null, null, null, 'array');
	}
}

