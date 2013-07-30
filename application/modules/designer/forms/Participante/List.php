<?php

/**
 * Formulário para listagem
 *
 * @package		Designer
 * @subpackage	Participante
 * @category	Form
 * @name		List
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class Designer_Form_Participante_List extends SanSIS_Form
{

	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
	{
		$id = $this->createElement('Hidden', 'id', array('value' => ''));

		$nome = $this->createElement('Text', 'nome', array('label' => 'Nome:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
		$nome->addValidator('StringLength', false, array(1, 100));
		
		$descricao = $this->createElement('Textarea', 'descricao', array('label' => 'Descrição:'));
		$descricao->addValidator('StringLength', false, array(0, 512));
		
		$status_tupla = $this->createElement('Select', 'status_tupla', array('label' => 'Status', 'required' => true, 'style' => 'width:300px'));

		$adicionar = $this->createElement ( 'submit', 'adicionar' , array('class' => 'button'));			
		$pesquisar = $this->createElement ( 'submit', 'pesquisar' , array('class' => 'button'));

		$this->addElements ( array ($id,$nome,$descricao, $status_tupla, $adicionar, $pesquisar) );
		
		$this->addDisplayGroup(
			array(
				'nome',
				'descricao',
				'status_tupla'
			),
			'simples',
			array(
				'legend' => 'Participante'
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