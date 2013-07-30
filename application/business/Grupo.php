<?php

/**
 * Business de Grupos de Atividades
 *
 * @package		ProFlow
 * @category	Business
 * @name		Grupo
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class ProFlow_Business_Grupo extends SanSIS_Business
{
	public $crudClass = 'ProFlow_Model_Grupo';
	
	public function getFormData($id = NULL)
	{
		$data = array();
		
		$src = new ProFlow_Model_Categoria();
		$list = $src->getList();
	
		foreach ($list as $cat)
			$data['categoria'][$cat['id']] = $cat['nome'];
		
		$src = new ProFlow_Model_Participante();
		$list = $src->getList();
		
		foreach ($list as $pat)
			$data['participante'][$pat['id']] = $pat['nome'];
	
		return $data;
	}
	
	/**
	* Salva dados submetidos
	* Deve ser implantado de acordo com a Business
	*/
	public function save($values)
	{
		//salvamos os dados do usuário
		parent::save($values);
		if (isset($values['id_categoria']))
			$this->crudObj->saveCategorias($values);
		
		$this->saveMembros($values);
	}
	
	/**
	* Retorna o mapeamento do objeto para popular o formulário
	* Deve ser implantado de acordo com a Business
	*/
	public function getMapping()
	{
		$cols = parent::getMapping();
	
		$cols[] = 'id_categoria';
	
		return $cols;
	}
	
	public function carregarMembros($id_grupo, $seed_id)
	{
		if (!isset($_SESSION[$seed_id]))
		{
			$src = new ProFlow_Model_GrupoUsuarioParticipante();
			return $_SESSION[$seed_id]['membros'] = $src->getGroupUsersList($id_grupo);
		}
		else
			return $_SESSION[$seed_id]['membros'];
	}
	
	public function incluirMembro($id_grupo, $usuario, $id_participante, $seed_id)
	{
		$src  = new SanSIS_Model_Auth_Usuario();
		$src2 = new ProFlow_Model_Participante();
		
		$i = count ($_SESSION[$seed_id]['membros']);
		
		$usuario = explode('(',$usuario);
		$login = str_replace(')', '', $usuario[1]);
		$usuario = $src->getUserByLogin($login);
		$row = $src2->fetchRow('id = '.$id_participante);
		
		//verificando se o usuário já não existe com esse papel
		if(isset($_SESSION[$seed_id]['membros']))
		{
			foreach ($_SESSION[$seed_id]['membros'] as $gup)
			{
				if (
						$id_participante == $gup['id_participante'] &&
						$usuario->id == $gup['id_usuario']
					)
					return false;
			}
		}
		
		$_SESSION[$seed_id]['membros'][$i]['id']				= '';
		$_SESSION[$seed_id]['membros'][$i]['id_usuario']		= $usuario->id;
		$_SESSION[$seed_id]['membros'][$i]['id_participante']	= $id_participante;
		$_SESSION[$seed_id]['membros'][$i]['Nome']				= $usuario->nome;
		$_SESSION[$seed_id]['membros'][$i]['Sobrenome']			= $usuario->sobrenome;
		$_SESSION[$seed_id]['membros'][$i]['Papel']				= $row['nome'];
		
		return true;
	}
	
	public function excluirMembro($id, $id_usuario, $id_participante, $seed_id)
	{
		if ($id)
			$_SESSION[$seed_id]['excluir'][] = $id;
		
		for ($i=0; $i < count($_SESSION[$seed_id]['membros']); $i++)
		{
			if (
				$id_participante == $_SESSION[$seed_id]['membros'][$i]['id_participante'] &&
				$id_usuario == $_SESSION[$seed_id]['membros'][$i]['id_usuario']
			)
			unset($_SESSION[$seed_id]['membros'][$i]);
		}
		
		$_SESSION[$seed_id]['membros'] = array_values($_SESSION[$seed_id]['membros']);	
	}
	
	public function saveMembros($values)
	{
		$seed_id = $values['seed_id'];
		
		$gup = new ProFlow_Model_GrupoUsuarioParticipante();
		
		if (isset($_SESSION[$seed_id]['excluir']))
			foreach ($_SESSION[$seed_id]['excluir'] as $value)
				$gup->delete('id = '.$value);
		
		
		foreach ($_SESSION[$seed_id]['membros'] as $assoc)
		{
			if (!$assoc['id'])
			{
				$gup = new ProFlow_Model_GrupoUsuarioParticipante();
				
				$gup->id_usuario 		= $assoc['id_usuario'];
				$gup->id_participante 	= $assoc['id_participante'];
				$gup->id_grupo 			= $this->crudObj->id;
				
				$gup->save();
			}
		}
	}
}