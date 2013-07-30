<?php

/**
 * Formulário para Edição/Criação de Grupos
 *
 * @package		Admin
 * @subpackage	Grupo
 * @category	Form
 * @name		Edit
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class Admin_Form_Grupo_Edit extends SanSIS_Form
{
	/**
     * Inicializa a criação do formulário
     */
    public function init()
    {
    	$this->getView()->headScript()->appendFile($this->getView()->baseUrl().'/js/forms/admin_grupo_edit.js');
    	
		$id = $this->createElement('Hidden', 'id', array('value' => ''));
		
		$seed_id = $this->createElement ( 'Hidden', 'seed_id', array ('value' => str_shuffle('abcdefg').rand(0,1000) ) );

    	$nome = $this->createElement('Text', 'nome', array('label' => 'Nome:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
		$nome->addValidator('StringLength', false, array(1, 100));
		
		$descricao = $this->createElement('Textarea', 'descricao', array('label' => 'Descrição:'));
		$descricao->addValidator('StringLength', false, array(0, 512));
		
		$status_tupla = $this->createElement('Select', 'status_tupla', array('label' => 'Status:', 'required' => true, 'style' => 'width:300px'));
		
		$usuario =  $this->createElement('Text', 'usuario', array('label' => 'Novo membro:', 'maxLength' => 100, 'style' => 'width:300px'));
		$usuario_real_name = $this->createElement('Hidden', 'usuario_real_name');
		
		$id_participante =  $this->createElement('Select', 'id_participante', array('label' => 'Participa como:', 'style' => 'width:300px'));
		
		$incluir = $this->createElement('button', 'incluir', array('class' => 'button', 'style'));
		
		$id_categoria =  $this->createElement('Multiselect', 'id_categoria', array('label' => 'Categorias:', 'style' => 'height:100px; width:300px'));

        $this->addElements(
        	array(
        		$id,
        		$seed_id,
	        	$nome,
	        	$descricao,
	        	$status_tupla,
        		$usuario,
        		$usuario_real_name,
        		$id_participante,
        		$incluir,
       			$id_categoria,
           )
       );
        
        $this->addDisplayGroup(
            array(
	        	'nome',
	        	'descricao',
        		'status_tupla',
           ),
            'formulario',
            array(
                'legend' => 'Grupo'
           ));         
        
        $this->addDisplayGroup(
	        array(
				'usuario',
				'id_participante',
				'incluir'
			),
	        'membros',
	                    array(
	        'legend' => 'Membros do grupo'
        ));    
        
        $this->addDisplayGroup(
	        array(
				'id_categoria',
			),
	        'categorias',
	                    array(
	        'legend' => 'Categorias em que atua'
        ));  
        
        
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

        parent::init();
    }

    public function populateFromModel($data)
    {
    	if(isset($data['categoria']) && count($data['categoria']))
    	{
	    	foreach ($data['categoria'] as $key=>$value)
	    		$this->getElement('id_categoria')->addMultiOption($key, $value);
    	}
    	else
    	{
    		$this->getElement('id_categoria')->addMultiOptions(array('' => 'Nenhum Perfil cadastrado'));
    	}
    	
    	if(isset($data['participante']) && count($data['participante']))
    	{
    		$this->getElement('id_participante')->addMultiOptions(array('' => 'Selecione abaixo'));
    		$this->getElement('id_participante')->addMultiOptions($data['participante']);
    	}
    	else
    	{
    		$this->getElement('id_participante')->addMultiOptions(array('' => 'Nenhum papel participante cadastrado'));
    	}
    	
    	$this->getElement('status_tupla')->addMultiOptions(array('1' => 'Ativo', '0' => 'Inativo'));
    }
}