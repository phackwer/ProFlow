<?php

/**
 * Formulário para listagem
 *
 * @package		Admin
 * @subpackage	Cidade
 * @category	Form
 * @name		List
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */
class Admin_Form_Cidade_List extends SanSIS_Form
{

	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
	{
		$this->getView()->headScript()->appendFile($this->getView()->baseUrl().'/js/functions/getLists.js');
		$this->getView()->headScript()->appendFile($this->getView()->baseUrl().'/js/forms/admin_cidade_list.js');
		 
		$id = $this->createElement('Hidden', 'id', array('value' => ''));
		 
		$nome = $this->createElement('Text', 'nome', array('label' => 'Nome:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
		$nome->addValidator('StringLength', false, array(1, 100));

		$id_uf = $this->createElement('Select', 'id_uf',array('label' => 'UF:', 'required' => true, 'style' => 'width:300px'));

		$id_pais = $this->createElement('Select', 'id_pais', array('label' => 'País:', 'required' => true, 'style' => 'width:300px'));

		$status_tupla = $this->createElement('Select', 'status_tupla', array('label' => 'Status:', 'required' => true, 'style' => 'width:300px'));

		$adicionar = $this->createElement ( 'submit', 'adicionar' , array('class' => 'button'));
		$pesquisar = $this->createElement ( 'submit', 'pesquisar' , array('class' => 'button'));

		$this->addElements (
		array (
		$id,
		$nome,
		$id_pais,
		$id_uf,
		$status_tupla,
		$adicionar,
		$pesquisar)
		);

		$this->addDisplayGroup(
		array(
            	'nome' , 
				'id_pais',
                'id_uf', 
				'status_tupla'
				),
            'simples',
				array(
                'legend' => 'Cidades'
                ) );
			
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
		if($data['pais'])
		{
			$this->getElement('id_pais')->addMultiOptions(array('' => 'Selecione abaixo'));
			$this->getElement('id_pais')->addMultiOptions($data['pais']);
		}
		 
		if(isset($data['uf']) && count($data['uf']))
		{
			$this->getElement('id_uf')->addMultiOptions(array('' => 'Selecione abaixo'));
			$this->getElement('id_uf')->addMultiOptions($data['uf']);
		}
		else
		{
			$this->getElement('id_uf')->addMultiOptions(array('' => 'Selecione o País antes'));
		}
		
		$this->getElement('status_tupla')->addMultiOptions(array('1' => 'Ativo', '0' => 'Inativo'));
		 
	}
}

