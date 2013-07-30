<?php

/**
 * Formulário para Visualização de Grupos
 *
 * @package		Admin
 * @subpackage	Grupo
 * @category	Form
 * @name		View
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class Admin_Form_Grupo_View extends SanSIS_Form
{
	/**
     * Inicializa a criação do formulário
     */
    public function init()
    {
    	$this->getView()->headScript()->appendFile($this->getView()->baseUrl().'/js/forms/admin_grupo_edit.js');
    	
		$id = $this->createElement('Hidden', 'id', array('value' => '', 'disabled' => 'true'));
		
		$seed_id = $this->createElement ( 'Hidden', 'seed_id', array ('value' => str_shuffle('abcdefg').rand(0,1000), 'disabled' => 'true' ) );

    	$nome = $this->createElement('Text', 'nome', array('label' => 'Nome:',  'maxLength' => 100, 'style' => 'width:300px', 'disabled' => 'true'));
		$nome->addValidator('StringLength', false, array(1, 100));
		
		$descricao = $this->createElement('Textarea', 'descricao', array('label' => 'Descrição:', 'disabled' => 'true'));
		$descricao->addValidator('StringLength', false, array(0, 512));
		
		$status_tupla = $this->createElement('Select', 'status_tupla', array('label' => 'Status:',  'style' => 'width:300px', 'disabled' => 'true'));
		
		$none = $this->createElement('Hidden', 'none', array('value' => ''));
		
		$id_categoria =  $this->createElement('Multiselect', 'id_categoria', array('label' => 'Categorias:', 'style' => 'height:100px; width:300px', 'disabled' => 'true'));

        $this->addElements(
        	array(
        		$id,
        		$seed_id,
	        	$nome,
	        	$descricao,
	        	$status_tupla,
        		$none,
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
				'none',
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
    	
    	$this->getElement('status_tupla')->addMultiOptions(array('1' => 'Ativo', '0' => 'Inativo'));
    }
}