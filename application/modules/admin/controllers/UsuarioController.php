<?php

/**
 * Controller Administrativo de Usuario
 *
 * @package		Admin
 * @category	Controller
 * @name		Usuario
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */
class Admin_UsuarioController extends SanSIS_Controller_CrudHTML
{
	
	protected $title 					= 'Administração';
	protected $bizClassName 			= 'Admin_Business_Usuario';
	
	protected $listSubTitle 			= 'Listar Usuários';
	protected $listFormClassName 		= 'Admin_Form_Usuario_List';
	protected $listSucessTarget 		= 'admin/usuario';
	protected $listCancelTarget 		= 'admin/';
	protected $listInfoMessage			= '';
	protected $listContextMenu 			= '';
	protected $listRowAction 			= array(
		array('Visualizar',	'/admin/usuario/view/id/{{id}}',		array('class' => 'icoVisualizar')),
		array('Editar',		'/admin/usuario/edit/id/{{id}}',		array('class' => 'icoEditar')),
        array('Excluir',	'/admin/usuario/delete/id/{{id}}',	array('class' => 'icoExcluir'))
    );
	protected $listMainAction 			= array(
		array('Excluir registros selecionados', '/admin/usuario/deleteall')
	);
	
	protected $createSubTitle 			= 'Criar Cadastro de Usuário';
	protected $createFormClassName 		= 'Admin_Form_Usuario_Edit';
	protected $createSucessTarget 		= 'admin/usuario';
	protected $createCancelTarget 		= 'admin/usuario';
	protected $createInfoMessage 		= '';
	protected $createContextMenu 		= '';
	
	protected $editSubTitle 			= 'Editar Cadastro de Usuário';
	protected $editFormClassName 		= 'Admin_Form_Usuario_Edit';
	protected $editSucessTarget 		= 'admin/usuario';
	protected $editCancelTarget 		= 'admin/usuario';
	protected $editFailureTarget 		= 'admin/usuario';
	protected $editInfoMessage 			= '';
	protected $editContextMenu 			= '';
	protected $editSubGrid 				= '';
	
	protected $viewSubTitle 			= 'Visualizar Cadastro de Usuário';
	protected $viewFormClassName 		= 'Admin_Form_Usuario_View';
	protected $viewSucessTarget 		= 'admin/usuario';
	protected $viewCancelTarget 		= 'admin/usuario';
	protected $viewInfoMessage 			= '';
	protected $viewContextMenu 			= '';
	protected $viewGridRadio 			= '';
	
	protected $deleteSubTitle 			= 'Remover Cadastro de Usuário';
	protected $deleteFormClassName 		= 'Admin_Form_Usuario_Delete';
	protected $deleteSucessTarget 		= 'admin/usuario';
	protected $deleteFailureTarget 		= 'admin/usuario';
	protected $deleteCancelTarget 		= 'admin/usuario';
	protected $deleteInfoMessage 		= '';
	protected $deleteContextMenu 		= '';
	
	protected $deleteAllSubTitle 		= 'Remover Cadastro de Usuários';
	protected $deleteAllFormClassName 	= 'Admin_Form_Usuario_Deleteall';
	protected $deleteAllSucessTarget 	= 'admin/usuario';
	protected $deleteAllFailureTarget 	= 'admin/usuario';
	protected $deleteAllCancelTarget 	= 'admin/usuario';
	protected $deleteAllInfoMessage		= '';
	protected $deleteAllContextMenu		= '';
	
	public function preDelete()
	{		
		$this->addMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_DELETE_DENIED, $this->deleteFailureTarget);
	}
	
	public function preDeleteAll()
	{
	
		$this->addMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_DELETE_DENIED, $this->deleteFailureTarget);
	}
}

