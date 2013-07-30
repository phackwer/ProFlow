<?php

/**
 * Modelo para regras de negócio referentes ao usuário
 *
 * @package		SanSIS
 * @subpackage	Model
 * @category	Auth
 * @name		Usuario
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */

class SanSIS_Model_Auth_Usuario extends SanSIS_Model_Auth_DbTable_Usuario
{
	public $id_pais;
	public $id_perfil = array();
	public $perfil = array();
	private $crypt = false;
	
	/**
	 * Sobrescreve o load default para carregar elementos de outras tabelas
	 * @see SanSIS_Model_Database_Abstract::load()
	 */
	public function load($id, $forUpdate = false)
	{
		parent::load($id);
		
		$this->carregaPerfis();
		
		return $this;
	}
	
	public function preSave()
	{
		if ($this->id)
			$olduserdata = new SanSIS_Model_Auth_Usuario($this->id);
		
		if ($this->id && !$this->senha)
		{
			$this->senha = $olduserdata->senha;
			
			$this->crypt = true;
		}
		if (
				!$this->crypt &&
				$this->senha
			)
		{
			$this->senha = hash('whirlpool', $this->senha);
			$this->crypt = true;
		}
		
		if ($this->id)
			$this->login = $olduserdata->login;
		
		parent::preSave();
	}
	
	public function authenticate($user, $pwd)
	{
		$where  = $this->getAdapter()->quoteInto( 'login = ?', $user);
		$where .= $this->getAdapter()->quoteInto( ' and senha = ?', $pwd);
		$result = $this->getAll($where, null, null, null, 'array');
		
		if (count($result) != 1)
			return false;
		else
		{
			$this->load($result[0]['id']);			
			return $this;
		}
			
	}
	
	public function getList($params)
	{
		if (!isset($params['status_tupla']))
			$where = 'usuario.status_tupla = \'1\'';
		else
			$where = 'usuario.status_tupla = \''.$params['status_tupla'].'\'';
		
		if (isset($params['nome']) && $params['nome'])
			$where .= ' and nome ILIKE \'%'.str_replace(' ', '%', $params['nome']).'%\'';
		
		$order = array(
			'usuario.nome'
		);
		
		$select = $this->select()
			->setIntegrityCheck(false)
			->from(array('usuario' => 'public.usuario'), array(
				'id' 		=> 'usuario.id',
				'Login'		=> 'usuario.login',
				'Nome'		=> 'usuario.nome',
				'Sobrenome' => 'usuario.sobrenome',
				'Status' 	=> 'usuario.status_tupla',
			)
		);
		
		$select->where($where)
		->order($order);
			
		//echo $select->assemble(); die; 
			
		$list = $this->getAll($select, null, null, null, 'array');
			
		foreach ($list as $item => $values)
		{
			$list[$item]['Status'] = $list[$item]['Status'] ? 'Ativo' : 'Inativo';
		}
		
		return $list;
	}
	
	public function limpaPerfis()
	{
		$this->carregaPerfis();
		
		foreach ($this->perfil as $perm)
			$perm->delete();
	}
	
	public function savePerfis($values)
	{
		$this->limpaPerfis();
		
		if (isset($values['id_perfil']) && $values['id_perfil'] && !is_array($values['id_perfil']))
			$values['id_perfil'] = array($values['id_perfil']);
		
		foreach ($values['id_perfil'] as $value)
		{		
				$perm = new SanSIS_Model_Auth_PerfilAcessoUsuario();
				$perm->id_usuario = $this->id;
				$perm->id_perfil_acesso = $value;
				$perm->save();
		}
		
	}
	
	public function carregaPerfis()
	{
		if (!count($this->id_perfil))
		{
			$perm 	= new SanSIS_Model_Auth_PerfilAcessoUsuario();
			$this->id_perfil = $perm->getUserIdPerfil(array('id_usuario' => $this->id));
			$this->perfil = $perm->getUserPerfis(array('id_usuario' => $this->id));
		}
		
		return $this->id_perfil;
	}
	
	public function checkPerfil($module, $controller, $action)
	{
		$this->carregaPerfis();
		
		if (isset($this->perfil['root']))			
			return true;
		
		if (isset($this->perfil['admin']) && $module == 'admin')
			return true;
		
		if (isset($this->perfil['designer']) && $module == 'designer')
			return true;
		
		if (isset($this->perfil['participant']) && $module == 'execution')
			return true;
				
		if (
				isset($this->perfil) && 
				(
					$module == 'default' ||
					(
						!$module &&
						!$controller &&
						!$action
					)
				)
			)
			return true;
		
		return false;
	}
	
	public function getUserByLogin($login)
	{
		$row = $this->fetchRow('login = \''.$login.'\'');
		return $row;
	}
}

