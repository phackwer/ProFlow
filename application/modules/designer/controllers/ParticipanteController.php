<?php

/**
 * Controller Design de Participante
 *
 * @package		Designer
 * @category	Controller
 * @name		Participante
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */
class Designer_ParticipanteController extends SanSIS_Controller_CrudHTMLSimples
{
	
	protected $title 					= 'Designer de Processos';
	protected $bizClassName 			= 'ProFlow_Business_Participante';
	
	protected $actionMenu				= array(
			'Pesquisar' => array (
					'action'		=> 'index'
	)
	);
	
	protected $listSubTitle 			= 'Manter Cadastro de Participantes';
	protected $listFormClassName 		= 'Designer_Form_Participante_List';
	protected $listSucessTarget 		= 'designer/participante';
	protected $listCancelTarget 		= 'designer/participante';
	protected $listRowAction 			= array(
		array('Editar',		'/designer/participante/list/id/{{id}}',	array('class' => 'icoEditar')),
        array('Excluir',	'/designer/participante/delete/id/{{id}}',	array('class' => 'icoExcluir'))
    );
	protected $listMainAction 			= array(
		array('Excluir registros selecionados', '/designer/participante/deleteall')
	);
	
	protected $deleteSubTitle 			= 'Remover Cadastro de Participante';
	protected $deleteFormClassName 		= 'Designer_Form_Participante_Delete';
	protected $deleteSucessTarget 		= 'designer/participante';
	protected $deleteFailureTarget 		= 'designer/participante';
	protected $deleteCancelTarget 		= 'designer/participante';
	protected $deleteInfoMessage 		= '';
	protected $deleteContextMenu 		= '';
	
	protected $deleteAllSubTitle 		= 'Remover Cadastro de Participantes';
	protected $deleteAllFormClassName 	= 'Designer_Form_Participante_Deleteall';
	protected $deleteAllSucessTarget 	= 'designer/participante';
	protected $deleteAllFailureTarget 	= 'designer/participante';
	protected $deleteAllCancelTarget 	= 'designer/participante';
	protected $deleteAllInfoMessage		= '';
	protected $deleteAllContextMenu		= '';

}

