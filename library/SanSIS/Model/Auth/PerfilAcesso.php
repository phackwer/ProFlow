<?php

/**
 * Modelo para regras de negócio referentes ao país
 *
 * @package		SanSIS
 * @subpackage	Model
 * @category	Auth
 * @name		PerfilAcesso
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */

class SanSIS_Model_Auth_PerfilAcesso extends SanSIS_Model_Auth_DbTable_PerfilAcesso
{
	public function getList($params = null)
	{
		$where = null;
		
		$current = Zend_Auth::getInstance()->getIdentity()->user;
		
		if (!isset($current->perfil['root']))
			$where = 'id <> 4';
		
		$orderby = 'nome ASC';
		
		return $this->getAll($where, $orderby, null, null, 'array');
	}
	
	public function checkACL($module, $controller)
	{
		if ($module != 'default' && $controller != 'installation')
		{
			return true;
		}
		return false;
	}
}

