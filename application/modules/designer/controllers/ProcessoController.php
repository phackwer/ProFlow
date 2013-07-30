<?php

/**
 * Controller Design de Processo
 *
 * @package		Designer
 * @category	Controller
 * @name		Processo
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */
class Designer_ProcessoController extends SanSIS_Controller_CrudHTML
{
	
	protected $title 					= 'Designer de Processos';
	protected $bizClassName 			= 'Designer_Business_Processo';
	
	protected $actionMenu				= array(
		'Pesquisar' => array (
				'action'		=> 'index'
			),
		'Criar' => array (
				'action'		=> 'create'
			)
		);
	
	protected $listSubTitle 			= 'Manter Cadastro de Processos';
	protected $listFormClassName 		= 'Designer_Form_Processo_List';
	protected $listSucessTarget 		= 'designer/processo';
	protected $listCancelTarget 		= 'designer/';
	protected $listInfoMessage			= '';
	protected $listContextMenu 			= '';
	protected $listRowAction 			= array(
		array('Visualizar',	'/designer/processo/view/id/{{id}}',		array('class' => 'icoVisualizar')),
		array('Editar',		'/designer/processo/edit/id/{{id}}',		array('class' => 'icoEditar')),
        array('Excluir',	'/designer/processo/delete/id/{{id}}',	array('class' => 'icoExcluir'))
    );
	protected $listMainAction 			= array(
		array('Excluir registros selecionados', '/designer/processo/deleteall')
	);
	
	protected $createSubTitle 			= 'Criar Cadastro de Processo';
	protected $createFormClassName 		= 'Designer_Form_Processo_Edit';
	protected $createSucessTarget 		= 'designer/processo';
	protected $createCancelTarget 		= 'designer/processo';
	protected $createInfoMessage 		= '';
	protected $createContextMenu 		= '';
	
	protected $editSubTitle 			= 'Editar Cadastro de Processo';
	protected $editFormClassName 		= 'Designer_Form_Processo_Edit';
	protected $editSucessTarget 		= 'designer/processo';
	protected $editCancelTarget 		= 'designer/processo';
	protected $editFailureTarget 		= 'designer/processo';
	protected $editInfoMessage 			= '';
	protected $editContextMenu 			= '';
	protected $editSubGrid 				= '';
	
	protected $viewSubTitle 			= 'Visualizar Cadastro de Processo';
	protected $viewFormClassName 		= 'Designer_Form_Processo_View';
	protected $viewSucessTarget 		= 'designer/processo';
	protected $viewCancelTarget 		= 'designer/processo';
	protected $viewInfoMessage 			= '';
	protected $viewContextMenu 			= '';
	protected $viewGridRadio 			= '';
	
	protected $deleteSubTitle 			= 'Remover Cadastro de Processo';
	protected $deleteFormClassName 		= 'Designer_Form_Processo_Delete';
	protected $deleteSucessTarget 		= 'designer/processo';
	protected $deleteFailureTarget 		= 'designer/processo';
	protected $deleteCancelTarget 		= 'designer/processo';
	protected $deleteInfoMessage 		= '';
	protected $deleteContextMenu 		= '';
	
	protected $deleteAllSubTitle 		= 'Remover Cadastro de Processos';
	protected $deleteAllFormClassName 	= 'Designer_Form_Processo_Deleteall';
	protected $deleteAllSucessTarget 	= 'designer/processo';
	protected $deleteAllFailureTarget 	= 'designer/processo';
	protected $deleteAllCancelTarget 	= 'designer/processo';
	protected $deleteAllInfoMessage		= '';
	protected $deleteAllContextMenu		= '';
}

