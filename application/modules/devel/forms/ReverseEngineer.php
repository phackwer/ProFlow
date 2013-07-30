<?php

/**
 * @package		Devel
 * @category	Form
 * @name		ReverseEngineer
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class Devel_Form_ReverseEngineer extends Zend_Form
{
	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
	{
		$Confirmar = $this->createElement ( 'submit', 'confirmar', array ('class' => 'button' ) );
		$Cancelar = $this->createElement ( 'submit', 'cancelar', array ('class' => 'button') );
		
		$arElements = $this->addElements ( array ($Confirmar, $Cancelar ) );
		
		$this->addDisplayGroup(array('confirmar', 'cancelar'), 'ActionBar');
		
		parent::init ();
	}
}