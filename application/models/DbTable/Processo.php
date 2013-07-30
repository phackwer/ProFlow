<?php
class ProFlow_Model_DbTable_Processo extends SanSIS_Model_Database_Abstract
{
protected $_schema = 'public';
protected $_name = 'processo';
protected $_sequence = 'public.processo_id_seq';

protected $_primary = array (
  0 => 'id',
);

protected $_cols = array (
  0 => 'id',
  1 => 'id_contexto_processo',
  2 => 'id_solicitante',
  3 => 'id_estado',
  4 => 'titulo',
  5 => 'descricao',
  6 => 'prioridade',
  7 => 'status_tupla',
);

protected $_metadata = array (
  'id' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'processo',
    'COLUMN_NAME' => 'id',
    'COLUMN_POSITION' => 1,
    'DATA_TYPE' => 'int4',
    'DEFAULT' => 'nextval(\'public.processo_id_seq\'::regclass)',
    'NULLABLE' => false,
    'LENGTH' => 4,
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => true,
    'PRIMARY_POSITION' => 1,
    'IDENTITY' => true,
  ),
  'id_contexto_processo' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'processo',
    'COLUMN_NAME' => 'id_contexto_processo',
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
  'id_solicitante' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'processo',
    'COLUMN_NAME' => 'id_solicitante',
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
  'id_estado' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'processo',
    'COLUMN_NAME' => 'id_estado',
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
  'titulo' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'processo',
    'COLUMN_NAME' => 'titulo',
    'COLUMN_POSITION' => 5,
    'DATA_TYPE' => 'varchar',
    'DEFAULT' => NULL,
    'NULLABLE' => false,
    'LENGTH' => '255',
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => false,
    'PRIMARY_POSITION' => NULL,
    'IDENTITY' => false,
  ),
  'descricao' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'processo',
    'COLUMN_NAME' => 'descricao',
    'COLUMN_POSITION' => 6,
    'DATA_TYPE' => 'text',
    'DEFAULT' => NULL,
    'NULLABLE' => false,
    'LENGTH' => -1,
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => false,
    'PRIMARY_POSITION' => NULL,
    'IDENTITY' => false,
  ),
  'prioridade' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'processo',
    'COLUMN_NAME' => 'prioridade',
    'COLUMN_POSITION' => 7,
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
  'status_tupla' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'processo',
    'COLUMN_NAME' => 'status_tupla',
    'COLUMN_POSITION' => 8,
    'DATA_TYPE' => 'bit',
    'DEFAULT' => 'B\'1\'::"bit"',
    'NULLABLE' => false,
    'LENGTH' => -1,
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