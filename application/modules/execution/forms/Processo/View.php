<?php

/**
 * Formulário para Visualização de Processos
 *
 * @package		Execution
 * @subpackage	Processo
 * @category	Form
 * @name		Edit
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class Execution_Form_Processo_View extends SanSIS_Form
{

	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
	{
		$cancelar = $this->createElement('submit', 'cancelar', array('class' => 'button'));
		 
		$this->addElements(
			array(
				$cancelar
			)
		);
		
		$this->addDisplayGroup(
			array(
				'cancelar'
			),
			'ActionBar'
		);

        parent::init();
	}
}