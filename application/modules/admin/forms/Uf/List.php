<?php

/**
 * Formulário para listagem
 *
 * @package		Admin
 * @subpackage	Uf
 * @category	Form
 * @name		List
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class Admin_Form_Uf_List extends SanSIS_Form
{

	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
	{
		$id = $this->createElement('Hidden', 'id', array('value' => ''));
		
		$sigla = $this->createElement('Text', 'sigla', array('label' => 'Sigla:', 'required' => true, 'maxLength' => 2, 'style' => 'width:50px'));
		$sigla->addValidator('StringLength', false, array(2, 2));
		
		$nome = $this->createElement('Text', 'nome', array('label' => 'Nome:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
		$nome->addValidator('StringLength', false, array(2, 100));
		
		$id_pais = $this->createElement('Select', 'id_pais', array('label' => 'País:', 'required' => true, 'style' => 'width:300px'));
		
		$status_tupla = $this->createElement('Select', 'status_tupla', array('label' => 'Status:', 'required' => true, 'style' => 'width:300px'));

		$adicionar = $this->createElement ( 'submit', 'adicionar' , array('class' => 'button'));			
		$pesquisar = $this->createElement ( 'submit', 'pesquisar' , array('class' => 'button'));
		
		$this->addElements(array($id, $sigla, $nome, $id_pais, $status_tupla, $adicionar, $pesquisar));
		
		$this->addDisplayGroup (
			array (
				'sigla' , 
				'nome' , 
				'id_pais', 
				'status_tupla'
			),
			'simples', 
			array (
				'legend' => 'UF'
			) );
			
		$this->addDisplayGroup(
			array(
				'adicionar',
				'pesquisar'
			),
			'ActionBar');	
		
		parent::init();
	}
	
	public function populateFromModel($data)
	{
		if ($data['pais'])
		{
			$this->getElement('id_pais')->addMultiOptions ( array ('' => 'Selecione abaixo' ) );
			$this->getElement('id_pais')->addMultiOptions($data['pais']);
		}
		
		$this->getElement('status_tupla')->addMultiOptions(array('1' => 'Ativo', '0' => 'Inativo'));
	}
}