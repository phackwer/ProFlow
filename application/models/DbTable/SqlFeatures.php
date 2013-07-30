<?php
class ProFlow_Model_DbTable_SqlFeatures extends SanSIS_Model_Database_Abstract
{
protected $_schema = 'information_schema';
protected $_name = 'sql_features';
protected $_sequence = '';

protected $_primary = array (
);

protected $_cols = array (
  0 => 'feature_id',
  1 => 'feature_name',
  2 => 'sub_feature_id',
  3 => 'sub_feature_name',
  4 => 'is_supported',
  5 => 'is_verified_by',
  6 => 'comments',
);

protected $_metadata = array (
  'feature_id' => 
  array (
    'SCHEMA_NAME' => 'information_schema',
    'TABLE_NAME' => 'sql_features',
    'COLUMN_NAME' => 'feature_id',
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
  'feature_name' => 
  array (
    'SCHEMA_NAME' => 'information_schema',
    'TABLE_NAME' => 'sql_features',
    'COLUMN_NAME' => 'feature_name',
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
  'sub_feature_id' => 
  array (
    'SCHEMA_NAME' => 'information_schema',
    'TABLE_NAME' => 'sql_features',
    'COLUMN_NAME' => 'sub_feature_id',
    'COLUMN_POSITION' => 3,
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
  'sub_feature_name' => 
  array (
    'SCHEMA_NAME' => 'information_schema',
    'TABLE_NAME' => 'sql_features',
    'COLUMN_NAME' => 'sub_feature_name',
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
  'is_supported' => 
  array (
    'SCHEMA_NAME' => 'information_schema',
    'TABLE_NAME' => 'sql_features',
    'COLUMN_NAME' => 'is_supported',
    'COLUMN_POSITION' => 5,
    'DATA_TYPE' => 'yes_or_no',
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
  'is_verified_by' => 
  array (
    'SCHEMA_NAME' => 'information_schema',
    'TABLE_NAME' => 'sql_features',
    'COLUMN_NAME' => 'is_verified_by',
    'COLUMN_POSITION' => 6,
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
    'TABLE_NAME' => 'sql_features',
    'COLUMN_NAME' => 'comments',
    'COLUMN_POSITION' => 7,
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