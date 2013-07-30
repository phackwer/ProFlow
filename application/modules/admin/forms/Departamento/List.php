<?php

/**
 * Formulário para listagem
 *
 * @package		Admin
 * @subpackage	Departamento
 * @category	Form
 * @name		List
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class Admin_Form_Departamento_List extends SanSIS_Form
{

	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
	{
		$id = $this->createElement('Hidden', 'id', array('value' => ''));

		$nome = $this->createElement('Text', 'nome', array('label' => 'Nome:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
		$nome->addValidator('StringLength', false, array(1, 100));
		
		$id_sob = $this->createElement('Select', 'id_sob', array('label' => 'Subordinado a', 'style' => 'width:300px'));
		
		$status_tupla = $this->createElement('Select', 'status_tupla', array('label' => 'Status', 'required' => true, 'style' => 'width:300px'));

		$adicionar = $this->createElement ( 'submit', 'adicionar' , array('class' => 'button'));			
		$pesquisar = $this->createElement ( 'submit', 'pesquisar' , array('class' => 'button'));

		$this->addElements ( array ($id,$nome,$id_sob,$status_tupla, $adicionar, $pesquisar) );
		
		$this->addDisplayGroup(
			array(
				'nome',
				'id_sob',
				'status_tupla'
			),
			'simples',
			array(
				'legend' => 'Departamento'
			));
			
		$this->addDisplayGroup(
			array(
				'adicionar',
				'pesquisar'
			),
			'ActionBar');

		parent::init ();
	}

	public function populateFromModel($data)
	{
		if (isset($data['departamento']) && count($data['departamento']))
		{
			foreach ($data['departamento'] as $key => $value)
				$data['departamento'][$key] = str_replace('&nbsp;', '-', $value);
			
			$this->getElement('id_sob')->addMultiOptions(array('' => 'Selecione abaixo'));
			$this->getElement('id_sob')->addMultiOptions($data['departamento']);
		}
		else
			$this->getElement('id_sob')->addMultiOptions(array('' => 'Nenhum departamento registrado ainda'));
		
		$this->getElement('status_tupla')->addMultiOptions(array('1' => 'Ativo', '0' => 'Inativo'));
	}
}