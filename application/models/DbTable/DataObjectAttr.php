<?php
class ProFlow_Model_DbTable_DataObjectAttr extends SanSIS_Model_Database_Abstract
{
protected $_schema = 'public';
protected $_name = 'data_object_attr';
protected $_sequence = 'public.data_object_attr_id_seq';

protected $_primary = array (
  0 => 'id',
);

protected $_cols = array (
  0 => 'id',
  1 => 'id_data_object',
  2 => 'id_type',
  3 => 'nulo',
  4 => 'default_value',
);

protected $_metadata = array (
  'id' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'data_object_attr',
    'COLUMN_NAME' => 'id',
    'COLUMN_POSITION' => 1,
    'DATA_TYPE' => 'int4',
    'DEFAULT' => 'nextval(\'public.data_object_attr_id_seq\'::regclass)',
    'NULLABLE' => false,
    'LENGTH' => 4,
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => true,
    'PRIMARY_POSITION' => 1,
    'IDENTITY' => true,
  ),
  'id_data_object' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'data_object_attr',
    'COLUMN_NAME' => 'id_data_object',
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
  'id_type' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'data_object_attr',
    'COLUMN_NAME' => 'id_type',
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
  'nulo' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'data_object_attr',
    'COLUMN_NAME' => 'nulo',
    'COLUMN_POSITION' => 4,
    'DATA_TYPE' => 'varbit',
    'DEFAULT' => 'B\'0\'::bit varying',
    'NULLABLE' => false,
    'LENGTH' => -1,
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => false,
    'PRIMARY_POSITION' => NULL,
    'IDENTITY' => false,
  ),
  'default_value' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'data_object_attr',
    'COLUMN_NAME' => 'default_value',
    'COLUMN_POSITION' => 5,
    'DATA_TYPE' => 'varchar',
    'DEFAULT' => NULL,
    'NULLABLE' => true,
    'LENGTH' => '1000',
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