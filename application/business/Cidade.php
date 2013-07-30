<?php

/**
 * Business de Cidades
 *
 * @package		ProFlow
 * @category	Business
 * @name		Cidade
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */
class ProFlow_Business_Cidade extends SanSIS_Business
{
	public $crudClass = 'ProFlow_Model_Cidade';

	public function getlistcidadesuf($values)
	{
		return $this->crudObj->getList($values);
	}
	
	/**
	 * Retorna o mapeamento do objeto para popular o formulário
	 * Deve ser implantado de acordo com a Business
	 */
	public function getMapping()
	{
		$cols = parent::getMapping();
		$cols[] = 'id_pais';
		return $cols;
	}

	public function getFormData($values = null)
	{
		$src = new ProFlow_Business_Pais();
		$paises = $src->getList();

		$data = array();
		$data['pais'] 	= array();
		$data['uf'] 	= array();

		foreach($paises as $pais)
		$data['pais'][$pais['id']] = $pais['nome'];

		if (isset($values['id']) || isset($values['id_pais']))
		{
			$src = new ProFlow_Business_Uf();
			
			if (isset($values['id']) && $values['id'] && !isset($values['id_pais']))
			{
				$this->crudObj->load($values['id']);
				$values['id_uf'] = $this->crudObj->id_uf;				
				$values['id_pais'] = $src->load($values['id_uf'])->id_pais;
			}
				
			if (isset($values['id_pais']) && $values['id_pais'])
			{
				$ufs = $src->getList(array("id_pais" => $values['id_pais']));

				foreach($ufs as $uf)
				$data['uf'][$uf['id']] = $uf['nome'];
			}
		}

		return $data;
	}

}