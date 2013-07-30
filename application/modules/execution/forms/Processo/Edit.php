<?php

/**
 * Formulário para edição de Processos
 *
 * @package		Execution
 * @subpackage	Processo
 * @category	Form
 * @name		Edit
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class Execution_Form_Processo_Edit extends SanSIS_Form
{

	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
	{
    	$adicionar = $this->createElement('submit', 'adicionar', array('class' => 'button'));
		$cancelar = $this->createElement('submit', 'cancelar', array('class' => 'button'));
		 
		$this->addElements(
			array(
				$adicionar,
				$cancelar
			)
		);
		
		$this->addDisplayGroup(
			array(
				'adicionar',
				'cancelar'
			),
			'ActionBar'
		);

        parent::init ();
	}
}