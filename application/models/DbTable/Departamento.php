<?php
class ProFlow_Model_DbTable_Departamento extends SanSIS_Model_Database_Abstract
{
protected $_schema = 'public';
protected $_name = 'departamento';
protected $_sequence = 'public.departamento_id_seq';

protected $_primary = array (
  0 => 'id',
);

protected $_cols = array (
  0 => 'id',
  1 => 'nome',
  2 => 'sigla',
  3 => 'id_subordinado_a',
  4 => 'status_tupla',
);

protected $_metadata = array (
  'id' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'departamento',
    'COLUMN_NAME' => 'id',
    'COLUMN_POSITION' => 1,
    'DATA_TYPE' => 'int4',
    'DEFAULT' => 'nextval(\'public.departamento_id_seq\'::regclass)',
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
    'TABLE_NAME' => 'departamento',
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
  'sigla' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'departamento',
    'COLUMN_NAME' => 'sigla',
    'COLUMN_POSITION' => 3,
    'DATA_TYPE' => 'varchar',
    'DEFAULT' => NULL,
    'NULLABLE' => true,
    'LENGTH' => '20',
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => false,
    'PRIMARY_POSITION' => NULL,
    'IDENTITY' => false,
  ),
  'id_subordinado_a' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'departamento',
    'COLUMN_NAME' => 'id_subordinado_a',
    'COLUMN_POSITION' => 4,
    'DATA_TYPE' => 'int4',
    'DEFAULT' => NULL,
    'NULLABLE' => true,
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
    'TABLE_NAME' => 'departamento',
    'COLUMN_NAME' => 'status_tupla',
    'COLUMN_POSITION' => 5,
    'DATA_TYPE' => 'varbit',
    'DEFAULT' => 'B\'1\'::bit varying',
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