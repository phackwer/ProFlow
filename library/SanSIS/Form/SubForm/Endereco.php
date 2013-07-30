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
class SanSIS_Form_SubForm_Endereco extends SanSIS_Form_SubForm_Localizacao
{

	public function init()
	{        
		$endereco = $this->createElement('Text', 'endereco', array('label' => 'Endereço:', 'maxLength' => 100, 'style' => 'width:300px'));
		$endereco->addValidator('StringLength', false, array(1, 100));

		$numero = $this->createElement('Text', 'numero', array('label' => 'Número:', 'maxLength' => 10, 'style' => 'width:300px'));
		$numero->addValidator('StringLength', false, array(1, 10));

		$complemento = $this->createElement('Text', 'complemento', array('label' => 'Complemento:', 'maxLength' => 10, 'style' => 'width:300px'));
		$complemento->addValidator('StringLength', false, array(1, 10));

		$bairro = $this->createElement('Text', 'bairro', array('label' => 'Bairro:', 'maxLength' => 30, 'style' => 'width:300px'));
		$bairro->addValidator('StringLength', false, array(1, 30));

		$cep = $this->createElement('Text', 'cep', array('label' => 'CEP:', 'maxLength' => 15, 'style' => 'width:300px', 'class' => 'cep'));
		$cep->addValidator('StringLength', false, array(1, 15));
		

		$this->addElements(
			array (
					$endereco,
					$numero,
					$complemento,
					$bairro,
					$cep
					)
			);
		
		parent::init();

	}
}