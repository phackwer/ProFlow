<?php

/**
 * Modelo para regras de negócio referentes à associação categoria-grupo
 *
 * @package		ProFlow
 * @subpackage	Model
 * @name		CategoriaGrupo
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */

class ProFlow_Model_CategoriaGrupo extends ProFlow_Model_DbTable_CategoriaGrupo
{
	public $nome;
	
	public function getList($params)
	{
		$where = 'id_grupo = '.$params['id_grupo'];
		
		return $this->getAll($where, null, null, null, 'array');
	}
	
	public function getGrupoIdCategoria($params)
	{
		$where = 'id_grupo = '.$params['id_grupo'];
		$cats =  $this->getAll($where);
		
		$categoria = new ProFlow_Model_Categoria();
		$return = array();
		
		foreach ($cats as $cat)
		{
			$where 							= 'id = '.$cat->id_categoria;
			$categoria 						= $categoria->getRow($where);
			$return[]						= $categoria->id;
		}
		
		return $return;
	}
	
	public function getGrupoCategorias($params)
	{
		$where = 'id_grupo = '.$params['id_grupo'];
		$cats =  $this->getAll($where);
		
		$categoria = new ProFlow_Model_Categoria();
		$return = array();
		
		foreach ($cats as $cat)
		{
			$where 							= 'id = '.$cat->id_categoria;
			$categoria 						= $categoria->getRow($where);
			$cat->nome						= $categoria->nome;
			$return[$categoria->nome]		= $cat;
		}
		
		return $return;
	}
}

