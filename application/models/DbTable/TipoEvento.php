<?php
class ProFlow_Model_DbTable_TipoEvento extends SanSIS_Model_Database_Abstract
{
protected $_schema = 'public';
protected $_name = 'tipo_evento';
protected $_sequence = 'public.tipo_evento_id_seq';

protected $_primary = array (
  0 => 'id',
);

protected $_cols = array (
  0 => 'id',
  1 => 'nome',
  2 => 'descricao',
  3 => 'tpl_valor_antigo',
  4 => 'tpl_valor_novo',
);

protected $_metadata = array (
  'id' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'tipo_evento',
    'COLUMN_NAME' => 'id',
    'COLUMN_POSITION' => 1,
    'DATA_TYPE' => 'int4',
    'DEFAULT' => 'nextval(\'public.tipo_evento_id_seq\'::regclass)',
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
    'TABLE_NAME' => 'tipo_evento',
    'COLUMN_NAME' => 'nome',
    'COLUMN_POSITION' => 2,
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
  'descricao' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'tipo_evento',
    'COLUMN_NAME' => 'descricao',
    'COLUMN_POSITION' => 3,
    'DATA_TYPE' => 'text',
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
  'tpl_valor_antigo' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'tipo_evento',
    'COLUMN_NAME' => 'tpl_valor_antigo',
    'COLUMN_POSITION' => 4,
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
  'tpl_valor_novo' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'tipo_evento',
    'COLUMN_NAME' => 'tpl_valor_novo',
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
);

}
?>