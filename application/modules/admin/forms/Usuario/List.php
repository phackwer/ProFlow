<?php

/**
 * Formulário para listagem
 *
 * @package		Admin
 * @subpackage	Usuario
 * @category	Form
 * @name		List
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class Admin_Form_Usuario_List extends SanSIS_Form
{

    /**
     * Inicializa a criação do formulário
     */
    public function init()
    {
    	$nome = $this->createElement('Text', 'nome', array('label' => 'Nome:', 'maxLength' => 100, 'style' => 'width:300px'));
		$nome->addValidator('StringLength', false, array(1, 100));
		
		$sobrenome = $this->createElement('Text', 'sobrenome', array('label' => 'Sobrenome:', 'maxLength' => 100, 'style' => 'width:300px'));
		$sobrenome->addValidator('StringLength', false, array(1, 100));
		
		$status_tupla = $this->createElement('Select', 'status_tupla', array('label' => 'Status:', 'style' => 'width:300px'));

        $pesquisar = $this->createElement ( 'submit', 'pesquisar', array ('class' => 'button' ) );
		$limpar = $this->createElement ( 'reset', 'limpar', array ('class' => 'button') );

        $this->addElements ( array ($nome, $sobrenome, $status_tupla, $pesquisar, $limpar) );
        
        $this->addDisplayGroup(
            array(
                'nome',
             	'sobrenome', 
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