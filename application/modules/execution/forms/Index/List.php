<?php
			
/**
 * Formulário para listagem de Processos
 *
 * @package		Execution
 * @subpackage	Processo
 * @category	Form
 * @name		List
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */
class Execution_Form_Index_List extends SanSIS_Form
{

	/**
	* Inicializa a criação do formulário
	*/
	public function init()
	{
		$nome = $this->createElement('Select', 'nome', array('label' => 'Status:', 'style' => 'width:300px', 'required' => true));
		
		$status_tupla = $this->createElement('Select', 'status_tupla', array('label' => 'Status:', 'style' => 'width:300px'));
		
		$pesquisar = $this->createElement ( 'submit', 'pesquisar', array ('class' => 'button' ) );
		$limpar = $this->createElement ( 'reset', 'limpar', array ('class' => 'button') );
		
		$this->addElements ( array ($nome, $status_tupla, $pesquisar, $limpar) );
		
		$this->addDisplayGroup(
			array(
				'nome',
				'status_tupla',
			),
			'filtro',
			array(
				'legend' => 'Filtro'
			) );
		
		$this->addDisplayGroup(
			array(
				'pesquisar',
				'limpar'
			),
			'ActionBar'
		);
		
		parent::init ();
	}
	
	public function populateFromModel($data)
	{
		$this->getElement('status_tupla')->addMultiOptions(array('1' => 'Ativo', '0' => 'Inativo'));
	}
}