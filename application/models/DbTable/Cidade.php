<?php
class ProFlow_Model_DbTable_Cidade extends SanSIS_Model_Database_Abstract
{
protected $_schema = 'public';
protected $_name = 'cidade';
protected $_sequence = 'public.cidade_id_seq';

protected $_primary = array (
  0 => 'id',
);

protected $_cols = array (
  0 => 'id',
  1 => 'nome',
  2 => 'id_uf',
  3 => 'status_tupla',
);

protected $_metadata = array (
  'id' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'cidade',
    'COLUMN_NAME' => 'id',
    'COLUMN_POSITION' => 1,
    'DATA_TYPE' => 'int4',
    'DEFAULT' => 'nextval(\'public.cidade_id_seq\'::regclass)',
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
    'TABLE_NAME' => 'cidade',
    'COLUMN_NAME' => 'nome',
    'COLUMN_POSITION' => 2,
    'DATA_TYPE' => 'varchar',
    'DEFAULT' => NULL,
    'NULLABLE' => false,
    'LENGTH' => '100',
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => false,
    'PRIMARY_POSITION' => NULL,
    'IDENTITY' => false,
  ),
  'id_uf' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'cidade',
    'COLUMN_NAME' => 'id_uf',
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
  'status_tupla' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'cidade',
    'COLUMN_NAME' => 'status_tupla',
    'COLUMN_POSITION' => 4,
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