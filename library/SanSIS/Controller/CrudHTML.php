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
abstract class SanSIS_Controller_CrudHTML extends SanSIS_Controller_CrudBase
{
	/**
	 * As variáveis abaixo devem ser setadas na classe que estende a Action,
	 * caso contrário, não funcionará 
	 */
	
	protected $actionMenu				= array(
			'Pesquisar' => array (
					'action'		=> 'index'
	),
			'Criar' => array (
					'action'		=> 'create'
	)
	);
	
	protected $createSubTitle 			= '';
	protected $createFormClassName 		= '';
	protected $createSucessTarget 		= '';
	protected $createSucessMessage 		= '';
	protected $createFailureTarget 		= '';
	protected $createFailureMessage 	= '';
	protected $createCancelTarget 		= '';
	protected $createInfoMessage 		= '';
	
	protected $editSubTitle 			= '';
	protected $editFormClassName 		= '';
	protected $editSucessTarget 		= '';
	protected $editSucessMessage 		= '';
	protected $editFailureTarget 		= '';
	protected $editFailureMessage 		= '';
	protected $editCancelTarget 		= '';
	protected $editInfoMessage 			= '';
	
	protected $viewSubTitle 			= '';
	protected $viewFormClassName 		= '';
	protected $viewSucessTarget 		= '';
	protected $viewFailureTarget 		= '';
	protected $viewCancelTarget 		= '';
	protected $viewInfoMessage 			= '';
	
	/**
	 * Ação para listagem.
	 */
	public function listAction()
	{
		//implementação de bloqueio para regras de negócio que escapem ao framework
		$this->preList();
		
		//definimos o subtítulo da página
		$this->setSubtitle($this->listSubTitle);
		
		//se foi definida uma mensagem de informação, apresenta-a na tela
		if($this->listInfoMessage)
		 $this->addInstantMessage(SanSIS_Message::TYPE_INFO , $this->listInfoMessage);
		
		$req = $this->getRequest();
		
		//componentes necessários ao controller
		$this->view->form = new $this->listFormClassName();
		$this->view->form->setAction($req->getBaseUrl().'/'.$req->getModuleName().'/'.$req->getControllerName().'/'.$req->getActionName());
		
		$values = $this->getRequest()->getParams();
		
		//populamos os combos com dados do banco
		$data = $this->biz->getFormData($this->getFormDataOnly($this->view->form));
		$this->view->form->populateFromModel($data);
		
		//cancelamento da ação		
		if(isset($values["cancelar"]))
		{
			header('Location: '.$this->baseurl.'/'.$this->listCancelTarget);				
			return;
		}
		
		try
		{
			$obGrid = '';
			
			if($this->view->form->isValid($this->getRequest()->getPost()))
			{
				// Busca os registros cadastrados
				$this->view->list = $this->biz->getList($this->getFormDataOnly($this->view->form));
				$this->view->listActions = array('edit' => $this->view->Url(array('module' => $this->getRequest()->getModuleName(), 'controller' => $this->getRequest()->getControllerName(), 'action' => 'edit', 'id' => '')), 'delete' => $this->view->Url(array('module' => $this->getRequest()->getModuleName(), 'controller' => $this->getRequest()->getControllerName(), 'action' => 'delete', 'id' => '')), 'transit' => $this->view->Url(array('module' => $this->getRequest()->getModuleName(), 'controller' => $this->getRequest()->getControllerName(), 'action' => 'transit', 'id' => '')));
				
				if(count($this->getRequest()->getPost()))
				{
					$this->view->form->populate($this->getRequest()->getPost());
				}
				
				// apresenta o grid
				if(count($this->view->list)>0)
				{
					$obGrid = new SanSIS_Grid();
					$obGrid->setData($this->view->list)
						   ->setTitle($this->listTitle);						   
						   if(!empty($this->listHeaderGrid))
						   {
								$obGrid->setHeader($this->listHeaderGrid);
						   }
						   $obGrid->setRowId($this->listRowId)
									->setColumnsHidden($this->listColumnsHidden);
							if($this->listSelecaoGrid == 'radio')
							{
								$obGrid->setRowInput(SanSIS_Grid::INPUT_TYPE_RADIO);
							}									
					foreach($this->listMainAction as $mainAction) 
					{
						$obGrid->addMainAction($mainAction[0], $this->baseurl . $mainAction[1]);
					}
					$rowAction=array();
					
					foreach($this->listRowAction as $actionButton) 
					{
						array_push(
							$rowAction,
							'<a href="'.
								$this->baseurl.$actionButton[1]
								.'" class="'.
								$actionButton[2]['class']
								.'" title="'.
								$actionButton[0]
								.'">'.
								$actionButton[0]
								.'</a>&nbsp;'
						);
					}
					$obGrid->setRowAction($rowAction);
				}
				else
				{
					$this->addInstantMessage(SanSIS_Message::TYPE_ALERT , SanSIS_Message::MSG_LIST_EMPTY);
				}
			}
	
			$this->view->grid = $obGrid;
			
			// Processa o form enviado
			if($this->getRequest()->isPost())
			{
				if(isset($values['formAction']))
				{
					// Nenhum registro selecionado
					if(!$values['id'])
						$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_NO_SELECTION);	   
					// Nenhuma ação selecionada
					if($values['formAction'] == '')
						$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_NO_ACTION);	   
					if(count($this->getRequest()->getPost()))
						$this->view->form->populate($this->getRequest()->getPost());
				}
			}
		}
		catch(Exception $e)
		{
			if(count($this->getRequest()->getPost()))
				$this->view->form->populate($this->getRequest()->getPost());
			
			$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, $e->getMessage());				
		}
	}
	
	public function preList()
	{
	}
	
	/**
	 * Ação para criação
	 */
	public function createAction()
	{
		//implementação de bloqueio para regras de negócio que escapem ao framework
		$this->preCreate();
		
		//definimos o subtítulo da página
		$this->setSubtitle($this->createSubTitle);
		
		//se foi definida uma mensagem de informação, apresenta-a na tela
		if($this->createInfoMessage)
		  $this->addInstantMessage(SanSIS_Message::TYPE_INFO , $this->createInfoMessage);
		
		//componentes necessários ao controller
		//form
		$this->view->form = new $this->createFormClassName();
		
		$values = $this->getRequest()->getParams();
		
		//populamos os combos com dados do banco
		$data = $this->biz->getFormData($this->getFormDataOnly($this->view->form));
		$this->view->form->populateFromModel($data);
		
		// Processa o form enviado
		if($this->getRequest()->isPost())
		{
			//cancelamento			
			if(isset($values["cancelar"]) || isset($values["voltar"]))
			{
				header('Location: '.$this->baseurl.'/'.$this->createCancelTarget);				
				return;
			}
			
			if($this->view->form->isValid($this->getRequest()->getPost()))
			{				
				try
				{
					$this->biz->save($this->getFormDataOnly($this->view->form));
					if ($this->createSucessMessage)
						$this->addMessage(SanSIS_Message::TYPE_SUCCESS, $this->createSucessMessage, $this->createSucessTarget);
					else
						$this->addMessage(SanSIS_Message::TYPE_SUCCESS, SanSIS_Message::MSG_SUCCESS, $this->createSucessTarget);
				}
				catch(Exception $e)
				{
					$this->addInstantMessage(SanSIS_Message::TYPE_ALERT, $e->getMessage());
				}
			}
			else
			{
				$this->view->form->populate($this->getRequest()->getPost());
				$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_INVALID);
			}
		}
	}
	
	public function preCreate()
	{
	}

	
	/**
	 * Ação para edição
	 */
	public function editAction()
	{
		//implementação de bloqueio para regras de negócio que escapem ao framework
		$this->preEdit();
		
		//define o subtítulo da página
		$this->setSubtitle($this->editSubTitle);
		
		//se foi definida uma mensagem de informação, apresenta-a na tela
		if($this->editInfoMessage)
		  $this->addInstantMessage(SanSIS_Message::TYPE_INFO , $this->editInfoMessage);
		
		//componentes necessários ao controller
		//form
		$this->view->form = new $this->editFormClassName();
		
		$values = $this->getRequest()->getParams();
	
		//popula os combos com dados do banco
		$data = $this->biz->getFormData($this->getFormDataOnly($this->view->form));
		$this->view->form->populateFromModel($data);
		
		if($values['id'])
			$object = $this->populateForm($values['id'] , $this->getFormDataOnly($this->view->form));
			
		
		// Processa o form enviado
		if($this->getRequest()->isPost())
		{			
			if(isset($values["cancelar"]) || isset($values["voltar"]))
			{
				header('Location: '.$this->baseurl.'/'.$this->editCancelTarget);
				return;
			}
			
			if($this->view->form->isValid($this->getRequest()->getPost()))
			{
				try
				{
					$values = $this->getFormDataOnly($this->view->form);
					$this->biz->save($values);
					
					if ($this->editSucessMessage)
						$this->addMessage(SanSIS_Message::TYPE_SUCCESS, $this->editSucessMessage, $this->editSucessTarget);
					else
						$this->addMessage(SanSIS_Message::TYPE_SUCCESS, SanSIS_Message::MSG_SUCCESS, $this->editSucessTarget);
				}
				catch(Exception $e)
				{
					$this->addInstantMessage(SanSIS_Message::TYPE_ALERT, $e->getMessage());
				}
			}
			else
			{
				$this->view->form->populate($this->getRequest()->getPost());
				$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_INVALID);
			}
		}
	}
	
	public function preEdit()
	{
	}
	/**
	 * Ação para visualização
	 */
	public function viewAction()
	{
		$this->setFormMethod = null;
		
		//implementação de bloqueio para regras de negócio que escapem ao framework
		$this->preView();
		
		// Processa o form enviado
		if($this->getRequest()->isPost()) {
			//cancelamento
			$values = $this->getRequest()->getParams();
			if(isset($values["cancelar"]))
			{
				header('Location: '.$this->baseurl.'/'.$this->viewCancelTarget);
				return;
			}
		}
		
		//define o subtítulo da página
		$this->setSubtitle($this->viewSubTitle);
		
		//se foi definida uma mensagem de informação, apresenta-a na tela
		if($this->viewInfoMessage)
		  $this->addInstantMessage(SanSIS_Message::TYPE_INFO , $this->viewInfoMessage);
		
		//componentes necessários ao controller
		//form
		$this->view->form = new $this->viewFormClassName();
		
		// Recupera o id do registro
		$id =(int) $this->getRequest()->getParam('id');
		
		//popula os combos com dados do banco
		$data = $this->biz->getFormData($this->getFormDataOnly($this->view->form));
		$this->view->form->populateFromModel($data);
		
		if($id)
		{			
			$object = $this->populateForm($id);
		}
	}
	
	public function preView()
	{
	}
}