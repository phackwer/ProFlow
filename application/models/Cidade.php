<?php

/**
 * Modelo para regras de negócio referentes a cidade
 *
 * @package		ProFlow
 * @subpackage	models
 * @category	Model
 * @name		Cidade
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */

class ProFlow_Model_Cidade extends ProFlow_Model_DbTable_Cidade
{
	public $id_pais;
	
	public function load($id, $forUpdate = false)
	{
		parent::load($id, $forUpdate);
		
		$uf = new ProFlow_Model_Uf($this->id_uf);		
		$this->id_pais = $uf->id_pais;
		
		return $this;
	}
	
	public function getList($params = null)
	{
		if (!isset($params['status_tupla']))
			$where = 'cidade.status_tupla = \'1\'';
		else
			$where = 'cidade.status_tupla = \''.$params['status_tupla'].'\'';

		$where .= ' and uf.status_tupla = \'1\'';
		$where .= ' and pais.status_tupla = \'1\'';
		
		if (isset($params['nome']) && $params['nome'])
			$where .= ' and cidade.nome ILIKE \'%'.str_replace(' ', '%', $params['nome']).'%\'';
			
		if (isset($params['id_uf']) && $params['id_uf'])
			$where .= ' and cidade.id_uf = '.$params['id_uf'];
			
		if (isset($params['id_pais']) && $params['id_pais'])
			$where .= ' and uf.id_pais = '.$params['id_pais'];
		
		$order = array(
			'cidade.nome' , 
			'uf.nome' , 
			'pais.nome'
		);
		
		$select = $this->select()
			->setIntegrityCheck(false)
			->from(array('cidade' => 'public.cidade'), array(
				'id' 		=> 'cidade.id',
				'nome' 		=> 'cidade.nome',
			)
		)
		->join(array('uf' => 'public.uf'), 'cidade.id_uf = uf.id', array(
			'UF' => 'uf.sigla'
		))
		->join(array('pais' => 'public.pais'), 'uf.id_pais = pais.id', array(
			'país' => 'pais.nome'
		))
		->where($where)
		->order($order);
			
		return $this->getAll($select, null, null, null, 'array');
	}
}

