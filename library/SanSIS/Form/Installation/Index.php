<?php

/**
 * Formulário para EULA
 *
 * @package		SanSIS
 * @subpackage	Form
 * @category	Form
 * @name		Index
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class SanSIS_Form_Installation_Index extends SanSIS_Form_Wizard
{

	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
	{
		$contrato = $this->createElement('Textarea', 'contrato', array('label' => 'Licenciamento','readOnly' => true));
// 		$contrato->setValue($value);

		$confirma = $this->createElement('Select', 'confirma', array('label' => 'Concorda com os termos acima?', 'required' => true));
		$confirma->addMultiOptions(
				array(
					'' => 'Confirme abaixo acordância com os termos de licença para poder prosseguir', 
					'1' => 'Sim, confirmo que li e concordo com os termos de uso acima'
				)
		);

		$this->addElements(array($contrato, $confirma));
		
		$this->addDisplayGroup(
			array(
				'contrato',
				'confirma'
			),
			'termos',
			array(
				'legend' => 'Termos de uso'
			));
		
		parent::init ();
	}
	
	public function isValid($values)
	{
		if (!isset($values['confirma']) || !$values['confirma'])
		{
			$this->markAsError();
			$this->confirma->addError('Não é possível prosseguir com a instalação sem estar de acordo com os termos acima.');
			
			return false;
		}
		
		return true;
	}
}