<?php

/**
 * NÃO CODIFIQUE REGRAS AQUI! ESTE É APENAS O
 * OBJETO DE BANCO DE DADOS PARA A TABELA!
 */

/**
 * Modelo Abstrato para acesso ao banco de dados
 * Acrescenta a possibilidade de fazer metamapping
 *
 * @package		SanSIS
 * @subpackage	Model
 * @category	Auth DbTable
 * @name		PerfilAcessoUsuario
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */

abstract class SanSIS_Model_Auth_DbTable_PerfilAcessoUsuario extends SanSIS_Model_Database_Abstract
{	
	//nome da tabela
	protected $_name	 = 'perfil_acesso_usuario';
	//nome da sequence
	protected $_sequence = 'public.perfil_acesso_usuario_id_seq';
	//primary key
	protected $_primary  = array(
		'id',
		);
	//colunas
	protected $_cols	 = array(
		'id',
		'id_usuario',
		'id_perfil_acesso'
		);
}
