<?php

/**
* Controller Execução de Index
 *
 * @package		Execution
 * @category	Controller
 * @name		Index
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */
class Execution_IndexController extends SanSIS_Controller_CrudHTML
{
	protected $title 					= 'Processos';
	protected $bizClassName 			= 'Execution_Business_Processo';
	
	protected $indexSubTitle 			= 'Área de trabalho - Caixa de Entrada';
	protected $indexFormClassName 		= 'Execution_Form_Index_List';
	protected $indexSucessTarget 		= '';
	protected $indexCancelTarget 		= '';
	protected $indexInfoMessage 		= '';
	protected $indexRowAction 			= array(
			array('Visualizar',	'/execution/processo/view/id/{{id}}',	array('class' => 'icoVisualizar')),
			array('Editar',		'/execution/processo/edit/id/{{id}}',	array('class' => 'icoEditar'))
	);
	
	public function indexAction()
	{
		//implementação de bloqueio para regras de negócio que escapem ao framework
		$this->preIndex();
		
		//definimos o subtítulo da página
		$this->setSubtitle($this->indexSubTitle);
		
		//se foi definida uma mensagem de informação, apresenta-a na tela
		if($this->indexInfoMessage)
		 $this->addInstantMessage(SanSIS_Message::TYPE_INFO , $this->indexInfoMessage);
		
		$req = $this->getRequest();
		
		//componentes necessários ao controller
		$this->view->form = new $this->indexFormClassName();
		$this->view->form->setAction($req->getBaseUrl().'/'.$req->getModuleName().'/'.$req->getControllerName().'/'.$req->getActionName());
		
		$values = $this->getRequest()->getParams();
		
		//populamos os combos com dados do banco
		$data = $this->biz->getFormData($this->getFormDataOnly($this->view->form));
		$this->view->form->populateFromModel($data);
		
		//cancelamento da ação		
		if(isset($values["cancelar"]))
		{
			header('Location: '.$this->baseurl.'/'.$this->indexCancelTarget);				
			return;
		}
		
		try
		{
			$obGrid = '';
			
			if($this->view->form->isValid($this->getRequest()->getPost()))
			{
				// Busca os registros cadastrados
				$this->view->list = $this->biz->getList($this->getFormDataOnly($this->view->form));
				$this->view->listActions = array('edit' => $this->view->Url(array('module' => $this->getRequest()->getModuleName(), 'controller' => $this->getRequest()->getControllerName(), 'action' => 'edit', 'id' => '')), 'transit' => $this->view->Url(array('module' => $this->getRequest()->getModuleName(), 'controller' => $this->getRequest()->getControllerName(), 'action' => 'transit', 'id' => '')));
				
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


}

