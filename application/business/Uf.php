<?php

/**
 * Business de UF
 *
 * @package		ProFlow
 * @category	Business
 * @name		Uf
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class ProFlow_Business_Uf extends SanSIS_Business
{
	public $crudClass = 'ProFlow_Model_Uf';
	
	public function getFormData($values = null)
	{
		$src = new ProFlow_Business_Pais();
		$paises = $src->getList();
		
		$data = array();
		$data['pais'] = array();
		
		foreach($paises as $pais)
		{
			$data['pais'][$pais['id']] = $pais['nome'];
		}
		
		return $data;
	}
	
	public function getlistufspais($values)
	{
		return $this->crudObj->getList($values);
	}
}