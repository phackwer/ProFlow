<?php
class ProFlow_Model_DbTable_EstadoProcesso extends SanSIS_Model_Database_Abstract
{
protected $_schema = 'public';
protected $_name = 'estado_processo';
protected $_sequence = 'public.estado_processo_id_seq';

protected $_primary = array (
  0 => 'id',
);

protected $_cols = array (
  0 => 'id',
  1 => 'nome',
  2 => 'finaliza',
);

protected $_metadata = array (
  'id' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'estado_processo',
    'COLUMN_NAME' => 'id',
    'COLUMN_POSITION' => 1,
    'DATA_TYPE' => 'int4',
    'DEFAULT' => 'nextval(\'public.estado_processo_id_seq\'::regclass)',
    'NULLABLE' => false,
    'LENGTH' => 4,
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => true,
    'PRIMARY_POSITION' => 1,
    'IDENTITY' => true,
  ),
  'nome' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'estado_processo',
    'COLUMN_NAME' => 'nome',
    'COLUMN_POSITION' => 2,
    'DATA_TYPE' => 'varchar',
    'DEFAULT' => NULL,
    'NULLABLE' => false,
    'LENGTH' => '30',
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => false,
    'PRIMARY_POSITION' => NULL,
    'IDENTITY' => false,
  ),
  'finaliza' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'estado_processo',
    'COLUMN_NAME' => 'finaliza',
    'COLUMN_POSITION' => 3,
    'DATA_TYPE' => 'bit',
    'DEFAULT' => 'B\'0\'::"bit"',
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