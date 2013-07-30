<?php
class ProFlow_Model_DbTable_GrupoUsuarioParticipante extends SanSIS_Model_Database_Abstract
{
protected $_schema = 'public';
protected $_name = 'grupo_usuario_participante';
protected $_sequence = 'public.grupo_usuario_participante_id_seq';

protected $_primary = array (
  0 => 'id',
);

protected $_cols = array (
  0 => 'id',
  1 => 'id_grupo',
  2 => 'id_usuario',
  3 => 'id_participante',
);

protected $_metadata = array (
  'id' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'grupo_usuario_participante',
    'COLUMN_NAME' => 'id',
    'COLUMN_POSITION' => 1,
    'DATA_TYPE' => 'int4',
    'DEFAULT' => 'nextval(\'public.grupo_usuario_participante_id_seq\'::regclass)',
    'NULLABLE' => false,
    'LENGTH' => 4,
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => true,
    'PRIMARY_POSITION' => 1,
    'IDENTITY' => true,
  ),
  'id_grupo' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'grupo_usuario_participante',
    'COLUMN_NAME' => 'id_grupo',
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
  'id_usuario' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'grupo_usuario_participante',
    'COLUMN_NAME' => 'id_usuario',
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
  'id_participante' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'grupo_usuario_participante',
    'COLUMN_NAME' => 'id_participante',
    'COLUMN_POSITION' => 4,
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