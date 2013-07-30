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
abstract class SanSIS_Controller_CrudHTMLSimples extends SanSIS_Controller_CrudBase
{
	protected $setFormMethod = 'setSimpleFormEditMode';
	
	public function setFormMode($values = null)
	{
		$this->view->form->setSimpleFormEditMode();
	}
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
		
		try
		{			
			if(isset($values["cancelar"]))
			{
				header('Location: '.$this->baseurl.'/'.$this->listCancelTarget);				
				return;
			}
			
			if(isset($values['adicionar']) || isset($values['salvar']))
			{	
				$this->view->list = $this->biz->getList();
				
				if($this->view->form->isValid($this->getRequest()->getPost()))
				{					
					$this->biz->save($this->getFormDataOnly($this->view->form));
					$this->addMessage(SanSIS_Message::TYPE_SUCCESS, SanSIS_Message::MSG_SUCCESS, $this->listSucessTarget);
				}
				else
				{
						if(count($this->getRequest()->getPost()))
							$this->view->form->populate($this->getRequest()->getPost());
						$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_INVALID);
				}
			}
			else if(isset($values['id']) && $values['id'])
			{
				$this->view->list = $this->biz->getList();
				
				$object = $this->populateForm($values['id'] , $this->getFormDataOnly($this->view->form));
			}
			else
			{
				// Busca os registros cadastrados
				$this->view->list = $this->biz->getList($this->getFormDataOnly($this->view->form));
				
				if(count($this->getRequest()->getPost()))
					$this->view->form->populate($this->getRequest()->getPost());
			}
			
			// Processa o form enviado
			if($this->getRequest()->isPost()) {
				$values = $this->getRequest()->getParams();
				if(isset($values['formAction'])){
					// Nenhum registro selecionado
					if(!$values['id']){
						$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_NO_SELECTION);	   
					}
					// Nenhuma ação selecionada
					if($values['formAction'] == ''){
						$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_NO_ACTION);	   
					}
					if(count($this->getRequest()->getPost()))
						$this->view->form->populate($this->getRequest()->getPost());
				}
			}
		}
		catch(Exception $e)
		{
			if(count($this->getRequest()->getPost()))
			{
				$this->view->form->populate($this->getRequest()->getPost());
			}
			$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, $e->getMessage());				
		}
		
		// apresenta o grid
		if(count($this->view->list)>0)
		{
			$obGrid = new SanSIS_Grid();
			$obGrid->setData($this->view->list)
			->setTitle($this->listTitle);
			if(!empty($this->listHeaderGrid)){
				$obGrid->setHeader($this->listHeaderGrid);
			}
			$obGrid->setRowId($this->listRowId)
			->setColumnsHidden($this->listColumnsHidden);
			if($this->listSelecaoGrid == 'radio'){
				$obGrid->setRowInput(SanSIS_Grid::INPUT_TYPE_RADIO);
			}
			foreach($this->listMainAction as $mainAction) {
				$obGrid->addMainAction($mainAction[0], $this->baseurl . $mainAction[1]);
			}
			$rowAction=array();
		
			foreach($this->listRowAction as $actionButton) {
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
			if (count($rowAction))
			$obGrid->setRowAction($rowAction);
		}
		else
		{
			$this->addInstantMessage(SanSIS_Message::TYPE_ALERT , SanSIS_Message::MSG_LIST_EMPTY);
			$obGrid = '';
		}
		
		$this->view->grid = $obGrid;
	}
	
	public function preList()
	{
	}
	
	public function populateForm($id, $extras = null)
	{
		// Busca os dados do registro selecionado
		$objeto = $this->biz->load($id);
		// Popula os campos do formulário
		$map = $this->biz->getMapping();
		foreach($map as $name)
		{
			$obj = $this->view->form->getElement($name);
			if($obj)
				$obj->setValue($objeto->$name);
		}
		
		$this->view->form->setSimpleFormEditMode();
		
		return $objeto;
	}
}