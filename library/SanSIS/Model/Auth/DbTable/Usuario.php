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
 * @category	Auth_DbTable
 * @name		Usuario
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */

abstract class SanSIS_Model_Auth_DbTable_Usuario extends SanSIS_Model_Database_Abstract_DelLogico
{	
	//nome da tabela
	protected $_name	 = 'usuario';
	//nome da sequence
	protected $_sequence = 'public.usuario_id_seq';
	//primary key
	protected $_primary  = array(
		'id',
		);
	//colunas
	protected $_cols	 = array(
		'id',
		'login',
		'senha',
		'nome',
		'sobrenome',
		'cargo',
		'email',
		'telefone',
		'endereco',
		'numero',
		'complemento',
		'bairro',
		'cep',
		'id_cidade',
		'id_uf',
		'id_pais',
		'id_departamento',
		'status_tupla'
		);
		
	protected $_metadata = array(
		'id_departamento' => array(
			'DATA_TYPE' => 'integer',
		),
		'id_pais' => array(
			'DATA_TYPE' => 'integer',
		),
		'id_uf' => array(
			'DATA_TYPE' => 'integer',
		),
		'id_cidade' => array(
			'DATA_TYPE' => 'integer',
		),
	);
}
