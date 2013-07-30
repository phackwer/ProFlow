<?php

/**
 * Formulário para Edição/Criação de Usuários
 * Pela natureza deste formulário, a parte de permissões está contida no populateFromModel
 *
 * @package		Admin
 * @subpackage	Usuario
 * @category	Form
 * @name		Edit
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class SanSIS_Form_Installation_Rootusercreation extends SanSIS_Form_Wizard
{
	/**
     * Inicializa a criação do formulário
     */
    public function init()
    {
		$login = $this->createElement('Text', 'login', array('label' => 'Login:', 'required' => true, 'maxLength' => 30, 'style' => 'width:300px'));
		$login->addValidator('StringLength', false, array(3, 30));

    	$senha = $this->createElement('Password', 'senha', array('label' => 'Senha:', 'required' => true, 'maxLength' => 30, 'style' => 'width:300px'));

    	$nome = $this->createElement('Text', 'nome', array('label' => 'Nome:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
		$nome->addValidator('StringLength', false, array(1, 100));
		
		$sobrenome = $this->createElement('Text', 'sobrenome', array('label' => 'Sobrenome:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
		$sobrenome->addValidator('StringLength', false, array(1, 100));
		
		$email = $this->createElement('Text', 'email', array('label' => 'Email:', 'required' => true, 'maxLength' => 100, 'style' => 'width:300px'));
		$email->addValidator('EmailAddress', false, array('domain' => false));
		
		$telefone = $this->createElement('Text', 'telefone', array('label' => 'Telefone:', 'required' => true, 'maxLength' => 30, 'style' => 'width:300px', 'class' => 'phone'));
		$telefone->addValidator('StringLength', false, array(14, 14));
		
		$id_perfil =  $this->createElement('Hidden', 'id_perfil', array('value' => 1));
		
		$status_tupla = $this->createElement('Hidden', 'status_tupla', array('value' => 1));

        $this->addElements(
        	array(
	        	$login,
	        	$senha,
	        	$nome,
	        	$sobrenome,
	        	$email,
	        	$telefone,
        		$id_perfil,
	        	$status_tupla
           )
       );
        
        $this->addDisplayGroup(
            array(
	        	'nome',
	        	'sobrenome',
	        	'cargo',
	        	'email',
	        	'telefone',	
           ),
            'formulario',
            array(
                'legend' => 'Usuário'
           ));        
        
        $this->addDisplayGroup(
	        array(
		        'login',
	        	'senha',
			),
	        'acesso',
	                    array(
	        'legend' => 'Dados de Acesso'
        ));

        parent::init();
    }
}