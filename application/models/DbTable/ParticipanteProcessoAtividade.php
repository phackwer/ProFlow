<?php
class ProFlow_Model_DbTable_ParticipanteProcessoAtividade extends SanSIS_Model_Database_Abstract
{
protected $_schema = 'public';
protected $_name = 'participante_processo_atividade';
protected $_sequence = 'public.participante_processo_atividade_id_seq';

protected $_primary = array (
  0 => 'id',
);

protected $_cols = array (
  0 => 'id',
  1 => 'id_participante',
  2 => 'id_atividade',
  3 => 'id_processo',
);

protected $_metadata = array (
  'id' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'participante_processo_atividade',
    'COLUMN_NAME' => 'id',
    'COLUMN_POSITION' => 1,
    'DATA_TYPE' => 'int4',
    'DEFAULT' => 'nextval(\'public.participante_processo_atividade_id_seq\'::regclass)',
    'NULLABLE' => false,
    'LENGTH' => 4,
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => true,
    'PRIMARY_POSITION' => 1,
    'IDENTITY' => true,
  ),
  'id_participante' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'participante_processo_atividade',
    'COLUMN_NAME' => 'id_participante',
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
  'id_atividade' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'participante_processo_atividade',
    'COLUMN_NAME' => 'id_atividade',
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
  'id_processo' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'participante_processo_atividade',
    'COLUMN_NAME' => 'id_processo',
    'COLUMN_POSITION' => 4,
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
);

}
?>