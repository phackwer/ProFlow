<?php

/**
 * Formulário para login
 *
 * @package		SanSIS
 * @subpackage	Form
 * @category	Form
 * @name		Wizard
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class SanSIS_Form_Wizard extends SanSIS_Form
{

	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
	{
		//botoes de navegação
		$prev = $this->createElement ( 'submit', 'anterior', 	array('class' => 'button') );
		$next = $this->createElement ( 'submit', 'próximo', 	array('class' => 'button') );
		
		$this->addElements ( array ($prev, $next) );
		
		$this->addDisplayGroup(
			array(
				'anterior',
				'próximo'
			),
			'ActionBar');

		parent::init ();
	}
	
	public function setActionButtons($prev, $next)
	{
		if (is_null($prev) || is_null($next))
			$this->removeElement('anterior');
	}
}