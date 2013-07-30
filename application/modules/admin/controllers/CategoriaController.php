<?php

/**
 * Controller Administrativo de Categoria
 *
 * @package		Admin
 * @category	Controller
 * @name		Categoria
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */
class Admin_CategoriaController extends SanSIS_Controller_CrudHTMLSimples
{
	
	protected $title 					= 'Administração';
	protected $bizClassName 			= 'ProFlow_Business_Categoria';
	
	protected $actionMenu				= array(
			'Pesquisar' => array (
					'action'		=> 'index'
	)
	);
	
	protected $listSubTitle 			= 'Listar Categorias';
	protected $listFormClassName 		= 'Admin_Form_Categoria_List';
	protected $listSucessTarget 		= 'admin/categoria';
	protected $listCancelTarget 		= 'admin/categoria';
	protected $listRowAction 			= array(
		array('Editar',		'/admin/categoria/list/id/{{id}}',	array('class' => 'icoEditar')),
        array('Excluir',	'/admin/categoria/delete/id/{{id}}',	array('class' => 'icoExcluir'))
    );
	protected $listMainAction 			= array(
		array('Excluir registros selecionados', '/admin/categoria/deleteall')
	);
	
	protected $deleteSubTitle 			= 'Remover Cadastro de Categoria';
	protected $deleteFormClassName 		= 'Admin_Form_Categoria_Delete';
	protected $deleteSucessTarget 		= 'admin/categoria';
	protected $deleteFailureTarget 		= 'admin/categoria';
	protected $deleteCancelTarget 		= 'admin/categoria';
	protected $deleteInfoMessage 		= '';
	protected $deleteContextMenu 		= '';
	
	protected $deleteAllSubTitle 		= 'Remover Cadastro de Categorias';
	protected $deleteAllFormClassName 	= 'Admin_Form_Categoria_Deleteall';
	protected $deleteAllSucessTarget 	= 'admin/categoria';
	protected $deleteAllFailureTarget 	= 'admin/categoria';
	protected $deleteAllCancelTarget 	= 'admin/categoria';
	protected $deleteAllInfoMessage		= '';
	protected $deleteAllContextMenu		= '';

}

