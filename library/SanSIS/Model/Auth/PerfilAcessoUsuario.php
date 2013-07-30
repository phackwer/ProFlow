<?php

/**
 * Modelo para regras de negócio referentes ao país
 *
 * @package		SanSIS
 * @subpackage	Model
 * @category	Auth
 * @name		PerfilAcessoUsuario
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */

class SanSIS_Model_Auth_PerfilAcessoUsuario extends SanSIS_Model_Auth_DbTable_PerfilAcessoUsuario
{
	public $nome;
	public $sysname;
	
	public function getList($params)
	{
		$where = 'id_usuario = '.$params['id_usuario'];
		
		return $this->getAll($where, null, null, null, 'array');
	}
	
	public function getUserIdPerfil($params)
	{
		$where = 'id_usuario = '.$params['id_usuario'];
		$perms =  $this->getAll($where);
		
		$perfil = new SanSIS_Model_Auth_PerfilAcesso();
		$return = array();
		
		foreach ($perms as $perm)
		{
			$where 							= 'id = '.$perm->id_perfil_acesso;
			$perfil 						= $perfil->getRow($where);
			$return[]						= $perfil->id;
		}
		
		return $return;
	}
	
	public function getUserPerfis($params)
	{
		$where = 'id_usuario = '.$params['id_usuario'];
		$perms =  $this->getAll($where);
		
		$perfil = new SanSIS_Model_Auth_PerfilAcesso();
		$return = array();
		
		foreach ($perms as $perm)
		{
			$where 							= 'id = '.$perm->id_perfil_acesso;
			$perfil 						= $perfil->getRow($where);
			$perm->sysname					= $perfil->sysname;
			$perm->nome						= $perfil->nome;
			$return[$perfil->sysname]		= $perm;
		}
		
		return $return;
	}
}

