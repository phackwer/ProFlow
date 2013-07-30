<?php
class ProFlow_Model_DbTable_Participante extends SanSIS_Model_Database_Abstract
{
protected $_schema = 'public';
protected $_name = 'participante';
protected $_sequence = 'public.participante_id_seq';

protected $_primary = array (
  0 => 'id',
);

protected $_cols = array (
  0 => 'id',
  1 => 'nome',
  2 => 'descricao',
  3 => 'status_tupla',
  4 => 'tipo',
);

protected $_metadata = array (
  'id' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'participante',
    'COLUMN_NAME' => 'id',
    'COLUMN_POSITION' => 1,
    'DATA_TYPE' => 'int4',
    'DEFAULT' => 'nextval(\'public.participante_id_seq\'::regclass)',
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
    'TABLE_NAME' => 'participante',
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
  'descricao' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'participante',
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
  'status_tupla' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'participante',
    'COLUMN_NAME' => 'status_tupla',
    'COLUMN_POSITION' => 4,
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
  'tipo' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'participante',
    'COLUMN_NAME' => 'tipo',
    'COLUMN_POSITION' => 5,
    'DATA_TYPE' => 'varchar',
    'DEFAULT' => NULL,
    'NULLABLE' => true,
    'LENGTH' => '32',
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