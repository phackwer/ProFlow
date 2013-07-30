<?php
class ProFlow_Model_DbTable_Evento extends SanSIS_Model_Database_Abstract
{
protected $_schema = 'public';
protected $_name = 'evento';
protected $_sequence = 'public.evento_id_seq';

protected $_primary = array (
  0 => 'id',
);

protected $_cols = array (
  0 => 'id',
  1 => 'id_processo',
  2 => 'id_tipo_evento',
  3 => 'datahora',
  4 => 'valor_anterior',
  5 => 'valor_atual',
);

protected $_metadata = array (
  'id' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'evento',
    'COLUMN_NAME' => 'id',
    'COLUMN_POSITION' => 1,
    'DATA_TYPE' => 'int4',
    'DEFAULT' => 'nextval(\'public.evento_id_seq\'::regclass)',
    'NULLABLE' => false,
    'LENGTH' => 4,
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => true,
    'PRIMARY_POSITION' => 1,
    'IDENTITY' => true,
  ),
  'id_processo' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'evento',
    'COLUMN_NAME' => 'id_processo',
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
  'id_tipo_evento' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'evento',
    'COLUMN_NAME' => 'id_tipo_evento',
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
  'datahora' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'evento',
    'COLUMN_NAME' => 'datahora',
    'COLUMN_POSITION' => 4,
    'DATA_TYPE' => 'timestamp',
    'DEFAULT' => NULL,
    'NULLABLE' => false,
    'LENGTH' => 8,
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => false,
    'PRIMARY_POSITION' => NULL,
    'IDENTITY' => false,
  ),
  'valor_anterior' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'evento',
    'COLUMN_NAME' => 'valor_anterior',
    'COLUMN_POSITION' => 5,
    'DATA_TYPE' => 'varchar',
    'DEFAULT' => NULL,
    'NULLABLE' => false,
    'LENGTH' => '500',
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => false,
    'PRIMARY_POSITION' => NULL,
    'IDENTITY' => false,
  ),
  'valor_atual' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'evento',
    'COLUMN_NAME' => 'valor_atual',
    'COLUMN_POSITION' => 6,
    'DATA_TYPE' => 'varchar',
    'DEFAULT' => NULL,
    'NULLABLE' => false,
    'LENGTH' => '500',
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