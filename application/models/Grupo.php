<?php

/**
 * Modelo para regras de negócio referentes ao grupo de atividades
 *
 * @package		ProFlow
 * @subpackage	models
 * @category	Model
 * @name		Grupo
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */

class ProFlow_Model_Grupo extends ProFlow_Model_DbTable_Grupo
{
	public $id_categoria = array();
	public $categoria = array();
	
	/**
	* Sobrescreve o load default para carregar elementos de outras tabelas
	* @see SanSIS_Model_Database_Abstract::load()
	*/
	public function load($id, $forUpdate = false)
	{
		parent::load($id);
	
		$this->carregaCategorias();
	
		return $this;
	}
	
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
	
	
	public function limpaCategorias()
	{
		$this->carregaCategorias();
		
		foreach ($this->categoria as $cat)
			$cat->delete();
	}
	
	public function saveCategorias($values)
	{
		$this->limpaCategorias();
	
		foreach ($values['id_categoria'] as $value)
		{		
			$cat = new ProFlow_Model_CategoriaGrupo();
			$cat->id_grupo = $this->id;
			$cat->id_categoria = $value;
			$cat->save();
		}
	
	}
	
	public function carregaCategorias()
	{
		if (!count($this->id_categoria))
		{
			$cat 	= new ProFlow_Model_CategoriaGrupo();
			$this->id_categoria = $cat->getGrupoIdCategoria(array('id_grupo' => $this->id));
			$this->categoria = $cat->getGrupoCategorias(array('id_grupo' => $this->id));
		}

		return $this->id_categoria;
	}
}

