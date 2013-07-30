<?php

/**
 * Controller Administrativo de País
 *
 * @package		Admin
 * @category	Controller
 * @name		Pais
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */
class Admin_PaisController extends SanSIS_Controller_CrudHTMLSimples
{
	
	protected $title 					= 'Administração';
	protected $bizClassName 			= 'ProFlow_Business_Pais';
	
	protected $actionMenu				= array(
			'Pesquisar' => array (
					'action'		=> 'index'
	)
	);
	
	protected $listSubTitle 			= 'Listar Países';
	protected $listFormClassName 		= 'Admin_Form_Pais_List';
	protected $listSucessTarget 		= 'admin/pais';
	protected $listCancelTarget 		= 'admin/pais';
	protected $listRowAction 			= array(
		array('Editar',		'/admin/pais/list/id/{{id}}',	array('class' => 'icoEditar')),
        array('Excluir',	'/admin/pais/delete/id/{{id}}',	array('class' => 'icoExcluir'))
    );
	protected $listMainAction 			= array(
		array('Excluir registros selecionados', '/admin/pais/deleteall')
	);
	
	protected $deleteSubTitle 			= 'Remover Cadastro de País';
	protected $deleteFormClassName 		= 'Admin_Form_Pais_Delete';
	protected $deleteSucessTarget 		= 'admin/pais';
	protected $deleteFailureTarget 		= 'admin/pais';
	protected $deleteCancelTarget 		= 'admin/pais';
	protected $deleteInfoMessage 		= '';
	protected $deleteContextMenu 		= '';
	
	protected $deleteAllSubTitle 		= 'Remover Cadastro de Países';
	protected $deleteAllFormClassName 	= 'Admin_Form_Pais_Deleteall';
	protected $deleteAllSucessTarget 	= 'admin/pais';
	protected $deleteAllFailureTarget 	= 'admin/pais';
	protected $deleteAllCancelTarget 	= 'admin/pais';
	protected $deleteAllInfoMessage		= '';
	protected $deleteAllContextMenu		= '';

}

