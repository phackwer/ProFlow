<?php

/**
 * Controller Administrativo de UF
 *
 * @package		Admin
 * @category	Controller
 * @name		Uf
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */
class Admin_UfController extends SanSIS_Controller_CrudHTMLSimples
{
	
	protected $title 					= 'Administração';
	protected $bizClassName 			= 'ProFlow_Business_Uf';
	
	protected $actionMenu				= array(
			'Pesquisar' => array (
					'action'		=> 'index'
	)
	);
	
	protected $listSubTitle 			= 'Listar UFs';
	protected $listFormClassName 		= 'Admin_Form_Uf_List';
	protected $listSucessTarget 		= 'admin/uf';
	protected $listCancelTarget 		= 'admin/uf';
	protected $listColumnsHidden 		= array('id', 'id_pais');
	protected $listRowAction 			= array(
		array('Editar',		'/admin/uf/list/id/{{id}}',	array('class' => 'icoEditar')),
        array('Excluir',	'/admin/uf/delete/id/{{id}}',	array('class' => 'icoExcluir'))
    );
	protected $listMainAction 			= array(
		array('Excluir registros selecionados', '/admin/uf/deleteall')
	);
	
	protected $deleteSubTitle 			= 'Remover Cadastro de UF';
	protected $deleteFormClassName 		= 'Admin_Form_Uf_Delete';
	protected $deleteSucessTarget 		= 'admin/uf';
	protected $deleteFailureTarget 		= 'admin/uf';
	protected $deleteCancelTarget 		= 'admin/uf';
	protected $deleteInfoMessage 		= '';
	protected $deleteContextMenu 		= '';
	
	protected $deleteAllSubTitle 		= 'Remover Cadastro de UF';
	protected $deleteAllFormClassName 	= 'Admin_Form_Uf_Deleteall';
	protected $deleteAllSucessTarget 	= 'admin/uf';
	protected $deleteAllFailureTarget 	= 'admin/uf';
	protected $deleteAllCancelTarget 	= 'admin/uf';
	protected $deleteAllInfoMessage		= '';
	protected $deleteAllContextMenu		= '';
}

