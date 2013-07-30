<?php
/**
 * Base para formulários.
 *
 * @package		SanSIS
 * @category	Form
 * @name		SubForm
 * @author		Carlos Eduardo Costa de Andrade <kaduppg@gmail.com>
 * @version		1.0.0
 */

class SanSIS_Form_SubForm_Localizacao extends SanSIS_Form_SubForm{

	public function init()
	{
		$this->getView()->headScript()->appendFile($this->getView()->baseUrl().'/js/functions/getLists.js');
    	
		$id_pais = $this->createElement('Select', 'id_pais', array('label' => 'País:', 'style' => 'width:300px'));
		$id_uf = $this->createElement('Select', 'id_uf', array('label' => 'UF:', 'style' => 'width:300px'));
		$id_cidade = $this->createElement('Select', 'id_cidade', array('label' => 'Cidade:', 'style' => 'width:300px'));

		$this->addElements(
		array (
				$id_pais,
				$id_uf,
				$id_cidade)
		);
            
        parent::init();
	}
}