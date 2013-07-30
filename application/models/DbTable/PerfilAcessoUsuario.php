<?php
class ProFlow_Model_DbTable_PerfilAcessoUsuario extends SanSIS_Model_Database_Abstract
{
protected $_schema = 'public';
protected $_name = 'perfil_acesso_usuario';
protected $_sequence = 'public.perfil_acesso_usuario_id_seq';

protected $_primary = array (
  0 => 'id',
);

protected $_cols = array (
  0 => 'id',
  1 => 'id_usuario',
  2 => 'id_perfil_acesso',
);

protected $_metadata = array (
  'id' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'perfil_acesso_usuario',
    'COLUMN_NAME' => 'id',
    'COLUMN_POSITION' => 1,
    'DATA_TYPE' => 'int4',
    'DEFAULT' => 'nextval(\'public.perfil_acesso_usuario_id_seq\'::regclass)',
    'NULLABLE' => false,
    'LENGTH' => 4,
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => true,
    'PRIMARY_POSITION' => 1,
    'IDENTITY' => true,
  ),
  'id_usuario' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'perfil_acesso_usuario',
    'COLUMN_NAME' => 'id_usuario',
    'COLUMN_POSITION' => 2,
    'DATA_TYPE' => 'int4',
    'DEFAULT' => NULL,
    'NULLABLE' => false,
    'LENGTH' => 4,
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => false,
    'PRIMARY_POSITION' => NULL,
    'IDENTITY' => false,
  ),
  'id_perfil_acesso' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'perfil_acesso_usuario',
    'COLUMN_NAME' => 'id_perfil_acesso',
    'COLUMN_POSITION' => 3,
    'DATA_TYPE' => 'int4',
    'DEFAULT' => NULL,
    'NULLABLE' => false,
    'LENGTH' => 4,
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => false,
    'PRIMARY_POSITION' => NULL,
    'IDENTITY' => false,
  ),
);

}
?>