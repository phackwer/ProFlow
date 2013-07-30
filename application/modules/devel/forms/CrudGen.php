<?php

/**
 * @package		Devel
 * @category	Form
 * @name		CrudGen
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class Devel_Form_CrudGen extends SanSIS_Form
{
	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
	{
	    $modulo_novo      = $this->createElement('Text', 'modulo_novo', array('label' => 'Módulo:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
	    $modulo_novo->addValidator('StringLength', false, array(1, 100));
	    
	    $controlador_novo = $this->createElement('Text', 'controlador_novo', array('label' => 'Controlador:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
	    $controlador_novo->addValidator('StringLength', false, array(1, 100));
	    
	    $tipo             = $this->createElement('Select', 'tipo', array('label' => 'Tipo de Crud:', 'style' => 'width:300px'));
	    $titulo           = $this->createElement('Text', 'titulo', array('label' => 'Título:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
	    $nome_plural      = $this->createElement('Text', 'nome_plural', array('label' => 'Nome Plural:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
	    $nome_singular    = $this->createElement('Text', 'nome_singular', array('label' => 'Nome Singular:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
	    
	    $tipo->addMultiOptions(array('CrudHTML' => 'Padrão (ações ind. de list, create, edit, view, delete)', 'CrudHTMLSimples' => 'Simples (ações conjuntas de list-create-edit, delete)'));
	    
		$Confirmar        = $this->createElement ( 'submit', 'confirmar', array ('class' => 'button' ) );
		$Cancelar         = $this->createElement ( 'submit', 'cancelar', array ('class' => 'button') );
		
		$arElements = $this->addElements ( array ( 
		        $modulo_novo, 
		        $controlador_novo,
		        $tipo,
		        $titulo,
		        $nome_plural,
		        $nome_singular, 
		        $Confirmar, 
		        $Cancelar ) );
		
		$this->addDisplayGroup(
		        array(
		                'modulo_novo' ,
		                'controlador_novo',
		                'tipo',
        		        'titulo',
        		        'nome_plural',
        		        'nome_singular',
		        ),
		        'simples',
		        array(
		                'legend' => 'Dados para o CRUD'
		        ) );
		
		$this->addDisplayGroup(array('confirmar', 'cancelar'), 'ActionBar');
		
		parent::init ();
	}
}