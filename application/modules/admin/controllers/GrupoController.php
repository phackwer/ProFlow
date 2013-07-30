<?php

/**
 * Controller Administrativo de Grupo
 *
 * @package		Admin
 * @category	Controller
 * @name		Grupo
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */
class Admin_GrupoController extends SanSIS_Controller_CrudHTML
{

	protected $title 					= 'Administração';
	protected $bizClassName 			= 'ProFlow_Business_Grupo';

	protected $actionMenu				= array(
		'Pesquisar' => array (
				'action'		=> 'index'
			),
		'Criar' => array (
				'action'		=> 'create'
			)
		);

	protected $listSubTitle 			= 'Listar Grupos';
	protected $listFormClassName 		= 'Admin_Form_Grupo_List';
	protected $listSucessTarget 		= 'admin/grupo';
	protected $listCancelTarget 		= 'admin/';
	protected $listInfoMessage			= '';
	protected $listContextMenu 			= '';
	protected $listRowAction 			= array(
		array('Visualizar',	'/admin/grupo/view/id/{{id}}',		array('class' => 'icoVisualizar')),
		array('Editar',		'/admin/grupo/edit/id/{{id}}',		array('class' => 'icoEditar')),
        array('Excluir',	'/admin/grupo/delete/id/{{id}}',	array('class' => 'icoExcluir'))
    );
	protected $listMainAction 			= array(
		array('Excluir registros selecionados', '/admin/grupo/deleteall')
	);

	protected $createSubTitle 			= 'Criar Cadastro de Grupo';
	protected $createFormClassName 		= 'Admin_Form_Grupo_Edit';
	protected $createSucessTarget 		= 'admin/grupo';
	protected $createCancelTarget 		= 'admin/grupo';
	protected $createInfoMessage 		= '';
	protected $createContextMenu 		= '';

	protected $editSubTitle 			= 'Editar Cadastro de Grupo';
	protected $editFormClassName 		= 'Admin_Form_Grupo_Edit';
	protected $editSucessTarget 		= 'admin/grupo';
	protected $editCancelTarget 		= 'admin/grupo';
	protected $editFailureTarget 		= 'admin/grupo';
	protected $editInfoMessage 			= '';
	protected $editContextMenu 			= '';
	protected $editSubGrid 				= '';

	protected $viewSubTitle 			= 'Visualizar Cadastro de Grupo';
	protected $viewFormClassName 		= 'Admin_Form_Grupo_View';
	protected $viewSucessTarget 		= 'admin/grupo';
	protected $viewCancelTarget 		= 'admin/grupo';
	protected $viewInfoMessage 			= '';
	protected $viewContextMenu 			= '';
	protected $viewGridRadio 			= '';

	protected $deleteSubTitle 			= 'Remover Cadastro de Grupo';
	protected $deleteFormClassName 		= 'Admin_Form_Grupo_Delete';
	protected $deleteSucessTarget 		= 'admin/grupo';
	protected $deleteFailureTarget 		= 'admin/grupo';
	protected $deleteCancelTarget 		= 'admin/grupo';
	protected $deleteInfoMessage 		= '';
	protected $deleteContextMenu 		= '';

	protected $deleteAllSubTitle 		= 'Remover Cadastro de Grupos';
	protected $deleteAllFormClassName 	= 'Admin_Form_Grupo_Deleteall';
	protected $deleteAllSucessTarget 	= 'admin/grupo';
	protected $deleteAllFailureTarget 	= 'admin/grupo';
	protected $deleteAllCancelTarget 	= 'admin/grupo';
	protected $deleteAllInfoMessage		= '';
	protected $deleteAllContextMenu		= '';


	public function carregarmembrosAction()
	{
		$this->_helper->layout()->disableLayout();

		$values 			= $this->getRequest ()->getParams ();

		$this->view->list 	= $this->biz->carregarmembros($values['id_grupo'], $values['seed_id']);;

		// apresenta o grid
		$this->view->grid = new SanSIS_Grid();
		$this->view->grid->setData($this->view->list);

		$this->view->grid->setRowId('id');
		$this->view->grid->setColumnsHidden(array('id', 'id_usuario', 'id_participante'));

		$this->view->grid->setPagination(false);

		//$this->view->grid->addMainAction('Excluir selecionados', $this->baseurl . '/admin/grupo/deleteallmembros');

		if (!isset($values['readOnly']))
		{
			$rowAction=array('<a onclick="excluir(\'{{id}}\', \'{{id_usuario}}\', \'{{id_participante}}\')" class="icoExcluir" title="Excluir">');
			$this->view->grid->setRowAction($rowAction);
		}
	}

	public function incluirmembroAction()
	{
		$values = $this->getRequest ()->getParams ();

		$response = $this->biz->incluirMembro($values['id_grupo'], $values['usuario'], $values['id_participante'], $values['seed_id']);
		if (!$response)
			echo '<div class="'.SanSIS_Message::TYPE_ALERT.'">'.SanSIS_Message::MSG_SAMEUSER.'</div>';

		//no final, retorna a listagem
		$this->carregarmembrosAction();
	}

	public function excluirmembroAction()
	{
		$values = $this->getRequest ()->getParams ();

		if (!isset($values['id']))
		$values['id'] = null;

		$response = $this->biz->excluirMembro($values['id'], $values['id_usuario'], $values['id_participante'], $values['seed_id']);

		//no final, retorna a listagem
		$this->carregarmembrosAction();
	}
}

