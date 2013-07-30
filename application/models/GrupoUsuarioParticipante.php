<?php

/**
 * Modelo para regras de negócio referentes à associação grupo/usuário/papel
 *
 * @package		ProFlow
 * @subpackage	models
 * @category	Model
 * @name		GrupoUsuario
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */

class ProFlow_Model_GrupoUsuarioParticipante extends ProFlow_Model_DbTable_GrupoUsuarioParticipante
{
	public function getGroupUsersList($id_grupo)
	{
		if ($id_grupo)
		{
			$select = $this->select()->setIntegrityCheck(false)
			->from(array('g' => 'public.grupo_usuario_participante'), array(
							'id' 				=> 'g.id',
							'id_participante' 	=> 'g.id_participante',
							'id_usuario' 		=> 'g.id_usuario',
			))
			->join(array('u' => 'usuario'), 'g.id_usuario=u.id',
				array(
						'Nome' 		=> 'u.nome',
						'Sobrenome' => 'u.sobrenome'
				)
			)
			->join(array('p' => 'participante'), 'g.id_participante=p.id',
				array('Papel' => 'p.nome')
			)
			->where('g.id_grupo = '.$id_grupo)
			->order('Nome');
			
			return $this->getAll($select, null, null, null, 'array');
		}
		return array();
	}
}

