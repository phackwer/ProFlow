<?php

/**
 * Business de Departamentos
 *
 * @package		ProFlow
 * @category	Business
 * @name		Departamento
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class ProFlow_Business_Departamento extends SanSIS_Business
{
	public $crudClass = 'ProFlow_Model_Departamento';
	
	public function getFormData($id = null)
	{
		$data = array();
		
		$list = $this->getList();
		
		foreach ($list as $item)
			$data['departamento'][$item['id']] = $item['nome'];
		
		return $data;
	}
}