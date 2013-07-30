<?php
/**
 * Classe para Controller de Processo
 *
 * @package	 Execution
 * @category	Controller
 * @name		ProcessoController
 * @version	 1.0.0
 */
class Execution_ProcessoController extends SanSIS_Controller_CrudHTML
{
	protected $title 					= 'Processos';
	protected $bizClassName 			= 'Execution_Business_Processo';

	protected $listSubTitle 			= 'Listar Processos';
	protected $listFormClassName 		= 'Execution_Form_Processo_List';
	protected $listSucessTarget 		= 'execution/processo';
	protected $listCancelTarget 		= 'execution/';
	protected $listInfoMessage			= '';
	protected $listContextMenu			= '';
	protected $listRowAction 			= array(
			array('Visualizar',	'/execution/processo/view/id/{{id}}',	array('class' => 'icoVisualizar')),
			array('Editar',		'/execution/processo/edit/id/{{id}}',	array('class' => 'icoEditar')),
			array('Excluir',	'/execution/processo/delete/id/{{id}}',	array('class' => 'icoExcluir'))
	);
	protected $listMainAction 			= array(
			array('Excluir registros selecionados', '/execution/processo/deleteall')
	);

	protected $createSubTitle			= 'Criar Cadastro de Processo';
	protected $createFormClassName		= 'Execution_Form_Processo_Edit';
	protected $createSucessTarget		= 'execution/processo';
	protected $createCancelTarget		= 'execution/processo';
	protected $createInfoMessage		= '';
	protected $createContextMenu		= '';

	protected $editSubTitle				= 'Editar Cadastro de Processo';
	protected $editFormClassName		= 'Execution_Form_Processo_Edit';
	protected $editSucessTarget			= 'execution/processo';
	protected $editCancelTarget			= 'execution/processo';
	protected $editFailureTarget		= 'execution/processo';
	protected $editInfoMessage			= '';
	protected $editContextMenu			= '';
	protected $editSubGrid				= '';

	protected $viewSubTitle				= 'Visualizar Cadastro de Processo';
	protected $viewFormClassName		= 'Execution_Form_Processo_View';
	protected $viewSucessTarget			= 'execution/processo';
	protected $viewCancelTarget			= 'execution/processo';
	protected $viewInfoMessage			= '';
	protected $viewContextMenu			= '';
	protected $viewGridRadio			= '';

	protected $deleteSubTitle			= 'Remover Cadastro de Processo';
	protected $deleteFormClassName		= 'Execution_Form_Processo_Delete';
	protected $deleteSucessTarget		= 'execution/processo';
	protected $deleteFailureTarget		= 'execution/processo';
	protected $deleteCancelTarget		= 'execution/processo';
	protected $deleteInfoMessage		= '';
	protected $deleteContextMenu		= '';

	protected $deleteAllSubTitle		= 'Remover Cadastro de Processos';
	protected $deleteAllFormClassName	= 'Execution_Form_Processo_Deleteall';
	protected $deleteAllSucessTarget	= 'execution/processo';
	protected $deleteAllFailureTarget	= 'execution/processo';
	protected $deleteAllCancelTarget	= 'execution/processo';
	protected $deleteAllInfoMessage		= '';
	protected $deleteAllContextMenu		= '';
}
