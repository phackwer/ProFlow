<?php

/**
 * Formulário para confirmação de remoção múltipla
 *
 * @package		Admin
 * @subpackage	Usuario
 * @category	Form
 * @name		Deleteall
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class Admin_Form_Usuario_Deleteall extends SanSIS_Form
{
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