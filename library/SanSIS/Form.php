<?php
/**
 * Base para formulários.
 *
 * @package		SanSIS
 * @category	Form
 * @name		Form
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class SanSIS_Form extends Zend_Form {
		
	/**
	 * Inicializa o form aplicando todo e qualquer fix necessário
	 * @see Zend_Form::init()
	 */
	public function init()
	{	
		parent::init();
		$this->fixHiddenDisplay();
	}

	/**
	 * Corrige o decorator para campos hidden
	 */
	public function fixHiddenDisplay()
	{
		$elements = $this->getElements();
		foreach ($elements as $element)
		{
			if ($element instanceof Zend_Form_Element_Hidden)
				$element->setDecorators(array('ViewHelper'));
		}
	}
	
	/**
	 * Método para popular o formulário com os dados advindos da Model pela Business
	 * Deve ser sobrescrito ou deixado inócuo 
	 * @param array $data
	 */
	public function populateFromModel($data)
	{
	}
	
	/**
	 * Altera os campos do formulário de criação/edição/pesquisa para os cruds simples
	 */
	public function setSimpleFormEditMode()
	{
		$displays = $this->getDisplayGroups();
		
		$salvar = $this->createElement('submit', 'salvar', array('class' => 'button'));			
		$cancelar = $this->createElement('submit', 'cancelar', array('class' => 'button'));
		
		foreach($displays as $display)
		{
			$adicionar 	= $display->getElement('adicionar');
			
			if ($adicionar)
			{
				$display->removeElement('adicionar');
				$display->removeElement('pesquisar');
				break;
			}
		}
		
		$this->addElements(array($salvar, $cancelar));
		
		$display->addElement($salvar);
		$display->addElement($cancelar);		
		
	}
	
	/**
	* Altera os campos do formulário de criação/edição para os cruds complexos
	*/
	public function setFormEditMode()
	{
		$displays = $this->getDisplayGroups();
		
		$salvar 	= $this->createElement('submit', 'salvar', array('class' => 'button'));
		
		foreach($displays as $display)
		{
			$cancelar 	= $display->getElement('cancelar');
			
			if ($cancelar)
			{
				$this->removeElement('cancelar');			
				$display->removeElement('adicionar');
				break;
			}
		}
			
		$this->addElements(array($salvar));
		
		$display->addElement($salvar);
		$display->addElement($cancelar);
	}
	
	/**
	 * Método auxiliar de depuração
	 */	
	public function debugHelp()
	{
		echo '<pre>';
		var_dump($this->getRequest()->getParams());
		
		$elements = $this->view->form->getElements();
		foreach ($elements as $element)
		{
			echo $element->getName().":\n";
			var_dump($element->getErrors());
		}
	}
}