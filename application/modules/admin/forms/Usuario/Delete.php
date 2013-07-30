<?php

/**
 * Formulário para confirmação de remoção
 *
 * @package		Admin
 * @subpackage	Usuario
 * @category	Form
 * @name		Delete
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class Admin_Form_Usuario_Delete extends SanSIS_Form {
	
	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
	{
		$id = $this->createElement ( 'Hidden', 'id', array ('value' => '' ) );
		
		$login = $this->createElement('Text', 'login', array('label' => 'Login:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
		$login->addValidator('StringLength', false, array(2, 100));
		
		$nome = $this->createElement('Text', 'nome', array('label' => 'Nome:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
		$nome->addValidator('StringLength', false, array(2, 100));
		
		$sobrenome = $this->createElement('Text', 'sobrenome', array('label' => 'Sobrenome:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
		$sobrenome->addValidator('StringLength', false, array(2, 100));
		
		$Confirmar = $this->createElement ( 'submit', 'confirmar', array ('class' => 'button' ) );
		$Cancelar = $this->createElement ( 'submit', 'cancelar', array ('class' => 'button') );
		
		$arElements = $this->addElements ( array ($id, $login, $nome, $sobrenome ) );
		
		$this->addDisplayGroup ( array ('login','nome', 'sobrenome'), 'idUsuario', array ('legend' => 'Usuário' ) );
		
		$arElements = $this->addElements ( array ($Confirmar, $Cancelar ) );
		
		$this->addDisplayGroup(array('confirmar', 'cancelar'), 'ActionBar');
		
		parent::init ();
	}
}