<?php

/**
 * Formulário para login
 *
 * @package		SanSIS
 * @subpackage	Form
 * @category	Form
 * @name		Login
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class SanSIS_Form_Login extends SanSIS_Form
{

	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
	{
		$username = $this->createElement('Text', 'username', array('label' => 'Usuário:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
		$username->addValidator('EmailAddress', false, array('domain' => false));

		$password = $this->createElement('Password', 'password', array('label' => 'Senha:', 'required' => true, 'maxLength' => 30, 'style' => 'width:300px'));
		$password->addValidator('StringLength', false, array(8, 30));	

		$login = $this->createElement ( 'submit', 'login', array('class' => 'button') );			
		$cancelar = $this->createElement ( 'submit', 'cancelar', array('class' => 'button') );

		$this->addElements ( array ($username,$password, $login, $cancelar) );
		
		$this->addDisplayGroup(
			array(
				'username',
				'password'
			),
			'simples',
			array(
				'legend' => 'Dados de login'
			));
			
		$this->addDisplayGroup(
			array(
				'login',
				'cancelar'
			),
			'ActionBar');

		parent::init ();
	}
}