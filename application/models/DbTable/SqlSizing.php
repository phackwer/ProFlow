<?php
class ProFlow_Model_DbTable_SqlSizing extends SanSIS_Model_Database_Abstract
{
protected $_schema = 'information_schema';
protected $_name = 'sql_sizing';
protected $_sequence = '';

protected $_primary = array (
);

protected $_cols = array (
  0 => 'sizing_id',
  1 => 'sizing_name',
  2 => 'supported_value',
  3 => 'comments',
);

protected $_metadata = array (
  'sizing_id' => 
  array (
    'SCHEMA_NAME' => 'information_schema',
    'TABLE_NAME' => 'sql_sizing',
    'COLUMN_NAME' => 'sizing_id',
    'COLUMN_POSITION' => 1,
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
  'sizing_name' => 
  array (
    'SCHEMA_NAME' => 'information_schema',
    'TABLE_NAME' => 'sql_sizing',
    'COLUMN_NAME' => 'sizing_name',
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
  'supported_value' => 
  array (
    'SCHEMA_NAME' => 'information_schema',
    'TABLE_NAME' => 'sql_sizing',
    'COLUMN_NAME' => 'supported_value',
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
  'comments' => 
  array (
    'SCHEMA_NAME' => 'information_schema',
    'TABLE_NAME' => 'sql_sizing',
    'COLUMN_NAME' => 'comments',
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
);

}
?>