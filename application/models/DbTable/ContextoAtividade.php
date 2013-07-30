<?php
class ProFlow_Model_DbTable_ContextoAtividade extends SanSIS_Model_Database_Abstract
{
protected $_schema = 'public';
protected $_name = 'contexto_atividade';
protected $_sequence = 'public.contexto_atividade_id_seq';

protected $_primary = array (
  0 => 'id',
);

protected $_cols = array (
  0 => 'id',
  1 => 'id_processo',
  2 => 'nome',
  3 => 'descricao',
  4 => 'evento_final_completo',
  5 => 'evento_terminal',
  6 => 'evento_cancelador',
);

protected $_metadata = array (
  'id' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'contexto_atividade',
    'COLUMN_NAME' => 'id',
    'COLUMN_POSITION' => 1,
    'DATA_TYPE' => 'int4',
    'DEFAULT' => 'nextval(\'public.contexto_atividade_id_seq\'::regclass)',
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
    'TABLE_NAME' => 'contexto_atividade',
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
  'nome' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'contexto_atividade',
    'COLUMN_NAME' => 'nome',
    'COLUMN_POSITION' => 3,
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
  'descricao' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'contexto_atividade',
    'COLUMN_NAME' => 'descricao',
    'COLUMN_POSITION' => 4,
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
  'evento_final_completo' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'contexto_atividade',
    'COLUMN_NAME' => 'evento_final_completo',
    'COLUMN_POSITION' => 5,
    'DATA_TYPE' => 'bit',
    'DEFAULT' => 'B\'0\'::"bit"',
    'NULLABLE' => false,
    'LENGTH' => -1,
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => false,
    'PRIMARY_POSITION' => NULL,
    'IDENTITY' => false,
  ),
  'evento_terminal' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'contexto_atividade',
    'COLUMN_NAME' => 'evento_terminal',
    'COLUMN_POSITION' => 6,
    'DATA_TYPE' => 'bit',
    'DEFAULT' => 'B\'0\'::"bit"',
    'NULLABLE' => false,
    'LENGTH' => -1,
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => false,
    'PRIMARY_POSITION' => NULL,
    'IDENTITY' => false,
  ),
  'evento_cancelador' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'contexto_atividade',
    'COLUMN_NAME' => 'evento_cancelador',
    'COLUMN_POSITION' => 7,
    'DATA_TYPE' => 'bit',
    'DEFAULT' => 'B\'0\'::"bit"',
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