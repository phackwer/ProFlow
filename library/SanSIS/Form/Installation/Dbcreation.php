<?php

/**
 * Formulário para criação do banco de dados
 *
 * @package		SanSIS
 * @subpackage	Form
 * @category	Form
 * @name		Dbcreation
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class SanSIS_Form_Installation_Dbcreation extends SanSIS_Form_Wizard
{

	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
	{
		$manual = $this->createElement('Select', 'manual', array('label' => 'Banco já criado?', 'required' => true));
		$manual->addMultiOptions(
			array(
					'' => 'Selecione abaixo',
					'0' => 'Não',
					'1' => 'Sim'
			)
		);
		
		$server = $this->createElement('Text', 'server', array('label' => 'Servidor:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
		$server->addValidator('StringLength', false, array(1, 100));
		
		$superuser = $this->createElement('Text', 'superuser', array('label' => 'Superusuário:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
		$superuser->addValidator('StringLength', false, array(1, 100));
		
		$passwd = $this->createElement('Password', 'passwd', array('label' => 'Senha:', 'required' => true, 'maxLength' => 30, 'style' => 'width:300px'));
		
		$dbname = $this->createElement('Text', 'dbname', array('label' => 'Nome do banco:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
		$dbname->addValidator('StringLength', false, array(1, 100));
		
		$this->addElements(array(
				$manual,
				$server,
				$superuser,
				$passwd,
				$dbname,
			)
		);
		
		$this->addDisplayGroup(
			array(
				'manual',
				'server',
				'superuser',
				'passwd',
				'dbname',
			),
			'termos',
			array(
				'legend' => 'Dados para criação de banco'
			));
		parent::init ();
	}
	
// 	public function isValid($values)
// 	{
// 		if ($values['manual'])
// 			return true;
		
// 		return parent::isValid($values);
// 	}
}