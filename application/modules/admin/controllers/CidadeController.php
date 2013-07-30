<?php

/**
 * Controller Administrativo de Cidade
 *
 * @package		Admin
 * @category	Controller
 * @name		Cidade
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */
class Admin_CidadeController extends SanSIS_Controller_CrudHTMLSimples
{
	
	protected $title 					= 'Administração';
	protected $bizClassName 			= 'ProFlow_Business_Cidade';
	
	protected $actionMenu				= array(
			'Pesquisar' => array (
					'action'		=> 'index'
	)
	);
	
	protected $listSubTitle 			= 'Listar Cidades';
	protected $listFormClassName 		= 'Admin_Form_Cidade_List';
	protected $listSucessTarget 		= 'admin/cidade';
	protected $listCancelTarget 		= 'admin/cidade';
	protected $listInfoMessage			= '';
	protected $listContextMenu 			= '';
	protected $listHeaderGrid 			= array();
	protected $listRowAction 			= array(
		array('Editar',		'/admin/cidade/list/id/{{id}}',	array('class' => 'icoEditar')),
        array('Excluir',	'/admin/cidade/delete/id/{{id}}',	array('class' => 'icoExcluir'))
    );
	protected $listMainAction 			= array(
		array('Excluir registros selecionados', '/admin/cidade/deleteall')
	);
	
	protected $deleteSubTitle 			= 'Remover Cadastro de Cidade';
	protected $deleteFormClassName 		= 'Admin_Form_Cidade_Delete';
	protected $deleteSucessTarget 		= 'admin/cidade';
	protected $deleteFailureTarget 		= 'admin/cidade';
	protected $deleteCancelTarget 		= 'admin/cidade';
	protected $deleteInfoMessage 		= '';
	protected $deleteContextMenu 		= '';
	
	protected $deleteAllSubTitle 		= 'Remover Cadastro de Cidades';
	protected $deleteAllFormClassName 	= 'Admin_Form_Cidade_Deleteall';
	protected $deleteAllSucessTarget 	= 'admin/cidade';
	protected $deleteAllFailureTarget 	= 'admin/cidade';
	protected $deleteAllCancelTarget 	= 'admin/cidade';
	protected $deleteAllInfoMessage		= '';
	protected $deleteAllContextMenu		= '';

}

