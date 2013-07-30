<?php

/**
 * Formulário para listagem
 *
 * @package		Admin
 * @subpackage	Categoria
 * @category	Form
 * @name		List
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class Admin_Form_Categoria_List extends SanSIS_Form
{

	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
	{
		$id = $this->createElement('Hidden', 'id', array('value' => ''));

		$nome = $this->createElement('Text', 'nome', array('label' => 'Nome:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
		$nome->addValidator('StringLength', false, array(1, 100));
		
		$status_tupla = $this->createElement('Select', 'status_tupla', array('label' => 'Status', 'required' => true, 'style' => 'width:300px'));

		$adicionar = $this->createElement ( 'submit', 'adicionar' , array('class' => 'button'));			
		$pesquisar = $this->createElement ( 'submit', 'pesquisar' , array('class' => 'button'));

		$this->addElements ( array ($id,$nome,$status_tupla, $adicionar, $pesquisar) );
		
		$this->addDisplayGroup(
			array(
				'nome',
				'status_tupla'
			),
			'simples',
			array(
				'legend' => 'Categoria'
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
		$this->getElement('status_tupla')->addMultiOptions(array('1' => 'Ativo', '0' => 'Inativo'));
	}
}