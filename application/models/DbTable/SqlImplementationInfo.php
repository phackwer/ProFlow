<?php
class ProFlow_Model_DbTable_SqlImplementationInfo extends SanSIS_Model_Database_Abstract
{
protected $_schema = 'information_schema';
protected $_name = 'sql_implementation_info';
protected $_sequence = '';

protected $_primary = array (
);

protected $_cols = array (
  0 => 'implementation_info_id',
  1 => 'implementation_info_name',
  2 => 'integer_value',
  3 => 'character_value',
  4 => 'comments',
);

protected $_metadata = array (
  'implementation_info_id' => 
  array (
    'SCHEMA_NAME' => 'information_schema',
    'TABLE_NAME' => 'sql_implementation_info',
    'COLUMN_NAME' => 'implementation_info_id',
    'COLUMN_POSITION' => 1,
    'DATA_TYPE' => 'character_data',
    'DEFAULT' => NULL,
    'NULLABLE' => true,
    'LENGTH' => -1,
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => false,
    'PRIMARY_POSITION' => NULL,
    'IDENTITY' => false,
  ),
  'implementation_info_name' => 
  array (
    'SCHEMA_NAME' => 'information_schema',
    'TABLE_NAME' => 'sql_implementation_info',
    'COLUMN_NAME' => 'implementation_info_name',
    'COLUMN_POSITION' => 2,
    'DATA_TYPE' => 'character_data',
    'DEFAULT' => NULL,
    'NULLABLE' => true,
    'LENGTH' => -1,
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => false,
    'PRIMARY_POSITION' => NULL,
    'IDENTITY' => false,
  ),
  'integer_value' => 
  array (
    'SCHEMA_NAME' => 'information_schema',
    'TABLE_NAME' => 'sql_implementation_info',
    'COLUMN_NAME' => 'integer_value',
    'COLUMN_POSITION' => 3,
    'DATA_TYPE' => 'cardinal_number',
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
  'character_value' => 
  array (
    'SCHEMA_NAME' => 'information_schema',
    'TABLE_NAME' => 'sql_implementation_info',
    'COLUMN_NAME' => 'character_value',
    'COLUMN_POSITION' => 4,
    'DATA_TYPE' => 'character_data',
    'DEFAULT' => NULL,
    'NULLABLE' => true,
    'LENGTH' => -1,
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => false,
    'PRIMARY_POSITION' => NULL,
    'IDENTITY' => false,
  ),
  'comments' => 
  array (
    'SCHEMA_NAME' => 'information_schema',
    'TABLE_NAME' => 'sql_implementation_info',
    'COLUMN_NAME' => 'comments',
    'COLUMN_POSITION' => 5,
    'DATA_TYPE' => 'character_data',
    'DEFAULT' => NULL,
    'NULLABLE' => true,
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