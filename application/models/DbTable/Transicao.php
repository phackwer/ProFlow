<?php
class ProFlow_Model_DbTable_Transicao extends SanSIS_Model_Database_Abstract
{
protected $_schema = 'public';
protected $_name = 'transicao';
protected $_sequence = 'public.transicao_id_seq';

protected $_primary = array (
  0 => 'id',
);

protected $_cols = array (
  0 => 'id',
  1 => 'id_origem',
  2 => 'id_destino',
  3 => 'id_processo',
);

protected $_metadata = array (
  'id' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'transicao',
    'COLUMN_NAME' => 'id',
    'COLUMN_POSITION' => 1,
    'DATA_TYPE' => 'int4',
    'DEFAULT' => 'nextval(\'public.transicao_id_seq\'::regclass)',
    'NULLABLE' => false,
    'LENGTH' => 4,
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => true,
    'PRIMARY_POSITION' => 1,
    'IDENTITY' => true,
  ),
  'id_origem' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'transicao',
    'COLUMN_NAME' => 'id_origem',
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
  'id_destino' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'transicao',
    'COLUMN_NAME' => 'id_destino',
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
  'id_processo' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'transicao',
    'COLUMN_NAME' => 'id_processo',
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