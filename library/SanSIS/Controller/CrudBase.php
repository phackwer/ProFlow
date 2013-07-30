<?php
/**
 * Controller básico para Crud
 *
 * @package		SanSIS
 * @subpackage	Controller
 * @category	Controller
 * @name		CrudHTML
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
abstract class SanSIS_Controller_CrudBase extends SanSIS_Controller_Action
{
	/**
	 * As variáveis abaixo devem ser setadas na classe que estende a Action,
	 * caso contrário, não funcionará 
	 */
	
	protected $setFormMethod = 'setFormEditMode';
		
	protected $indexSubTitle 			= '';
	protected $indexFormClassName 		= '';
	protected $indexSucessTarget 		= '';
	protected $indexCancelTarget 		= '';
	protected $indexInfoMessage 		= '';
	
	protected $listSubTitle 			= '';
	protected $listFormClassName 		= '';
	protected $listSucessTarget 		= '';
	protected $listFailureTarget 		= '';
	protected $listCancelTarget 		= '';
	protected $listInfoMessage			= '';
	protected $listSelecaoGrid			= null;
	protected $listHeaderGrid 			= array();
	protected $listRowAction 			= array();
	protected $listRowId 				= 'id';
	protected $listColumnsHidden 		= array('id', 'status_tupla');
	protected $listMainAction 			= array();
	protected $listTitle				= 'Lista';
	
	protected $deleteSubTitle 			= '';
	protected $deleteFormClassName 		= '';
	protected $deleteSucessTarget 		= '';
	protected $deleteFailureTarget 		= '';
	protected $deleteCancelTarget 		= '';
	protected $deleteInfoMessage 		= '';
	
	protected $deleteAllSubTitle 		= '';
	protected $deleteAllFormClassName 	= '';
	protected $deleteAllSucessTarget 	= '';
	protected $deleteAllFailureTarget 	= '';
	protected $deleteAllCancelTarget 	= '';
	protected $deleteAllInfoMessage		= '';
	
	/**
	 * Popula novamente o campo hidden id, quando o valor é enviado de outra action via submit
	 * Utilizado para açães com múltiplos registros
	 */
	public function populateId($values)
	{
		$this->view->form->getElement('id')->setValue($values);
	}
	
	/**
	 * Por padrão, consideramos que a ação inicial é a listagem dos itens
	 * Caso não seja, sobrescreva o método abaixo
	 * 
	 */
	public function indexAction()
	{
		//implementação de bloqueio para regras de negócio que escapem ao framework
		$this->preIndex();
		
		$this->listAction();
	}
	
	public function preIndex()
	{
	}
	
	/**
	 * Popula formulários de edição/criação e define modo de edição dos botões
	 */	
	public function populateForm($id, $extras = null)
	{
		// Busca os dados do registro selecionado
		$objeto = $this->biz->load($id);
		// Popula os campos do formulário
		$map = $this->biz->getMapping();
		$data = array();
		foreach($map as $name)
		{
			$obj = $this->view->form->getElement($name);
			
			if($obj)
			{
				if(isset($objeto->$name))
				{
					$class = $obj->getAttrib('class');
					
					if (strstr($class, 'money') || strstr($class, 'percentage'))
						$objeto->$name = number_format($objeto->$name, 2, ',', '.');
				
					$obj->setValue($objeto->$name);
				}
			}
			else
			{
				if(isset($objeto->$name))
					$this->populateSubForm($this->view->form, $objeto, $name);
			}
			if(isset($objeto->$name))
				$data[$name] = $objeto->$name;
		}
		
		$this->setFormMode($data);
		
		return $objeto;
	}
	
	public function populateSubForm(Zend_Form $parentForm, $objeto, $name)
	{
		$subs = $parentForm->getSubForms();
		foreach ($subs as $sub)
		{
			$obj = $sub->getElement($name);
			if($obj)
			{
				$class = $obj->getAttrib('class');
				
				if (strstr($class, 'money') || strstr($class, 'percentage'))
					$objeto->$name = number_format($objeto->$name, 2, ',', '.');
				
				$obj->setValue($objeto->$name);
			}
			else
			{
				if ($sub->getSubForms())
					$this->populateSubForm($sub, $obj, $name);
			}
		}
	}

	public function setFormMode($values = null)
	{
		$setform = $this->setFormMethod;
		if ($setform)
			$this->view->form->$setform($values);
	}
	/**
	 * Ação para remoção
	 * CUIDADO! Caso o CRUD não permita remoção, lembre-se de sobrescrever o método!!!
	 */
	public function deleteAction()
	{
		//implementação de bloqueio para regras de negócio que escapem ao framework
		$this->preDelete();
		
		//define o subtítulo da página
		$this->setSubtitle($this->deleteSubTitle);
		
		//se foi definida uma mensagem de informação, apresenta-a na tela
		if($this->deleteInfoMessage)
		  $this->addInstantMessage(SanSIS_Message::TYPE_INFO , $this->deleteInfoMessage);
		  
		$this->addInstantMessage(SanSIS_Message::TYPE_ALERT , SanSIS_Message::MSG_CONFIRM);
		
		//componentes necessários ao controller
		//form
		$this->view->form = new $this->deleteFormClassName();
		
		// Recupera o id do registro
		$values = $this->getRequest()->getParams();
		
		//popula os combos com dados do banco
		$data = $this->biz->getFormData($values);
		$this->view->form->populateFromModel($data);
		
		if($values['id'])
		{
			//cancelamento
			if(isset($values['cancelar']) || isset($values['voltar']))
			{
				header('Location: '.$this->baseurl.'/'.$this->deleteCancelTarget);
				return;
			}
			// Busca os dados do registro selecionado
			$objeto = $this->biz->load($values['id']);
			
			// Popula e desabilita os campos do formulário
			$map = $this->biz->getMapping();
			foreach($map as $name)
			{
				if ($this->view->form->getElement($name))
				{
					$this->view->form->getElement($name)->setValue($objeto->$name);
					$this->view->form->getElement($name)->setAttrib('disabled', 'true');
				}
			}
		}
		
		// Processa o form enviado
		if($this->getRequest()->isPost())
		{
			try
			{
				$this->biz->delete($objeto);
				$this->addMessage(SanSIS_Message::TYPE_SUCCESS, SanSIS_Message::MSG_SUCCESS, $this->deleteSucessTarget);
			}
			catch(Exception $e)
			{
				if($this->deleteFailureTarget)
					$this->addMessage(SanSIS_Message::TYPE_ALERT, $e->getMessage(), $this->deleteFailureTarget);
				else
					$this->addInstantMessage(SanSIS_Message::TYPE_ALERT, $e->getMessage());
			}
		}
	}
	
	public function preDelete()
	{
	}
	
	/**
	 * Ação para remoção dos registros selecionados
	 * CUIDADO! Caso o CRUD não permita remoção, lembre-se de sobrescrever o método!!!
	 */
	public function deleteallAction()
	{
		//implementação de bloqueio para regras de negócio que escapem ao framework
		$this->preDeleteall();
		
		//define o subtítulo da página
		$this->setSubtitle($this->deleteAllSubTitle);
		
		//se foi definida uma mensagem de informação, apresenta-a na tela
		if($this->deleteAllInfoMessage)
			$this->addInstantMessage(SanSIS_Message::TYPE_INFO , $this->deleteAllInfoMessage);
		
		$this->addInstantMessage(SanSIS_Message::TYPE_ALERT , SanSIS_Message::MSG_CONFIRM);
		
		//componentes necessários ao controller
		//form
		$this->view->form = new $this->deleteAllFormClassName();
		
		// recupera o form recebido do list
		$values = $this->getRequest()->getParams();
		
		// cancelamento
		if(isset($values["cancelar"]) || isset($values["voltar"]))
		{
			header('Location: '.$this->baseurl.'/'.$this->deleteAllCancelTarget);
			return;
		}
		
		if(!isset($values['flag']) || !$values['flag'])
		{
			// popula o form
			$this->populateId(implode(',', $values['id']));			
		}
		else
		{
			$values['id'] = explode(',', $values['id']);
		}
		
		// Nenhum registro selecionado
		if(!$values['id'])
		{
			$this->addMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_NO_SELECTION, $this->deleteAllCancelTarget);
		}
		
		// Processa o form enviado
		if($this->getRequest()->isPost() && isset($values['flag']) && $values['flag'])
		{
			try
			{
				foreach($values['id'] as $id)
				{
					$objeto = $this->biz->load($id);
					$this->biz->delete($objeto);
				}
				$this->addMessage(SanSIS_Message::TYPE_SUCCESS, SanSIS_Message::MSG_SUCCESS, $this->deleteAllSucessTarget);
			} 
			catch(Exception $e)
			{
				if($this->deleteAllFailureTarget)
					$this->addMessage(SanSIS_Message::TYPE_ALERT, $e->getMessage(), $this->deleteAllFailureTarget);
				else
					$this->addInstantMessage(SanSIS_Message::TYPE_ALERT, $e->getMessage());
			}
		}
	}
	
	public function preDeleteall()
	{
	}
}