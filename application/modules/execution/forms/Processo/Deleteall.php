<?php

/**
 * Formulário para confirmação de remoção múltipla de Processos
 *
 * @package		Execution
 * @subpackage	Processo
 * @category	Form
 * @name		Deleteall
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class Execution_Form_Processo_Deleteall extends SanSIS_Form {
	
	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
	{
		$id = $this->createElement ( 'Hidden', 'id', array ('value' => '' ) );
		
		$flag = $this->createElement ( 'Hidden', 'flag', array ('value' => '1' ) );
		
		$Confirmar = $this->createElement ( 'submit', 'confirmar', array ('class' => 'button' ) );
		$Cancelar = $this->createElement ( 'submit', 'cancelar', array ('class' => 'button') );
		
		$arElements = $this->addElements ( array ($id, $flag, $Confirmar, $Cancelar ) );
		
		$this->addDisplayGroup(array('confirmar', 'cancelar'), 'ActionBar');
		
		parent::init ();
	}
}