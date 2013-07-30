<?php

/**
 * Formulário para configuração do banco de dados
 *
 * @package		SanSIS
 * @subpackage	Form
 * @category	Form
 * @name		Dbconfig
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class SanSIS_Form_Installation_Dbconfig extends SanSIS_Form_Wizard
{

	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
	{
		$manual = $this->createElement('Select', 'manual', array('label' => 'Usuário já criado?', 'required' => true));
		$manual->addMultiOptions(
			array(
					'' => 'Selecione abaixo',
					'0' => 'Não',
					'1' => 'Sim'
			)
		);
		$manual->setDescription('Caso o usuário já tenha sido criado, tenha certeza que o mesmo não pode realizar nenhuma operação além de insert, update e select nas tabelas do sistema.');
		
		$server = $this->createElement('Text', 'server', array('label' => 'Servidor:', 'readOnly' => true, 'disabled' => true, 'maxLength' => 100, 'style' => 'width:300px'));
		$server->addValidator('StringLength', false, array(1, 100));
		
		$user = $this->createElement('Text', 'user', array('label' => 'Usuário:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
		$user->addValidator('StringLength', false, array(1, 100));
		
		$pass = $this->createElement('Password', 'pass', array('label' => 'Senha:', 'required' => true, 'maxLength' => 30, 'style' => 'width:300px'));
		
		$dbname = $this->createElement('Text', 'dbname', array('label' => 'Novo banco:',  'readOnly' => true, 'disabled' => true, 'maxLength' => 100, 'style' => 'width:300px'));
		$dbname->addValidator('StringLength', false, array(1, 100));
		
		$this->addElements(array(
				$manual,
				$server,
				$user,
				$pass,
				$dbname,
			)
		);
		
		$this->addDisplayGroup(
			array(
				'manual',
				'server',
				'user',
				'pass',
				'dbname',
			),
			'termos',
			array(
				'legend' => 'Dados para criação de banco'
			));
		parent::init ();
	}
	
	public function isValid($values)
	{
		if ($values['manual'])
			return true;
		
		return parent::isValid($values);
	}
}