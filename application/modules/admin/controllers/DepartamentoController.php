<?php

/**
 * Controller Administrativo de Departamento
 *
 * @package		Admin
 * @category	Controller
 * @name		Departamento
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */
class Admin_DepartamentoController extends SanSIS_Controller_CrudHTMLSimples
{
	
	protected $title 					= 'Administração';
	protected $bizClassName 			= 'ProFlow_Business_Departamento';
	
	protected $actionMenu				= array(
			'Pesquisar' => array (
					'action'		=> 'index'
	)
	);
	
	protected $listSubTitle 			= 'Listar Departamentos';
	protected $listFormClassName 		= 'Admin_Form_Departamento_List';
	protected $listSucessTarget 		= 'admin/departamento';
	protected $listCancelTarget 		= 'admin/departamento';
	protected $listRowAction 			= array(
		array('Editar',		'/admin/departamento/list/id/{{id}}',	array('class' => 'icoEditar')),
        array('Excluir',	'/admin/departamento/delete/id/{{id}}',	array('class' => 'icoExcluir'))
    );
	protected $listMainAction 			= array(
		array('Excluir registros selecionados', '/admin/departamento/deleteall')
	);
	
	protected $deleteSubTitle 			= 'Remover Cadastro de Departamento';
	protected $deleteFormClassName 		= 'Admin_Form_Departamento_Delete';
	protected $deleteSucessTarget 		= 'admin/departamento';
	protected $deleteFailureTarget 		= 'admin/departamento';
	protected $deleteCancelTarget 		= 'admin/departamento';
	protected $deleteInfoMessage 		= '';
	protected $deleteContextMenu 		= '';
	
	protected $deleteAllSubTitle 		= 'Remover Cadastro de Departamentos';
	protected $deleteAllFormClassName 	= 'Admin_Form_Departamento_Deleteall';
	protected $deleteAllSucessTarget 	= 'admin/departamento';
	protected $deleteAllFailureTarget 	= 'admin/departamento';
	protected $deleteAllCancelTarget 	= 'admin/departamento';
	protected $deleteAllInfoMessage		= '';
	protected $deleteAllContextMenu		= '';

}

