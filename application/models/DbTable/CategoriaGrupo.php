<?php
class ProFlow_Model_DbTable_CategoriaGrupo extends SanSIS_Model_Database_Abstract
{
protected $_schema = 'public';
protected $_name = 'categoria_grupo';
protected $_sequence = 'public.categoria_grupo_id_seq';

protected $_primary = array (
  0 => 'id',
);

protected $_cols = array (
  0 => 'id',
  1 => 'id_categoria',
  2 => 'id_grupo',
);

protected $_metadata = array (
  'id' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'categoria_grupo',
    'COLUMN_NAME' => 'id',
    'COLUMN_POSITION' => 1,
    'DATA_TYPE' => 'int4',
    'DEFAULT' => 'nextval(\'public.categoria_grupo_id_seq\'::regclass)',
    'NULLABLE' => false,
    'LENGTH' => 4,
    'SCALE' => NULL,
    'PRECISION' => NULL,
    'UNSIGNED' => NULL,
    'PRIMARY' => true,
    'PRIMARY_POSITION' => 1,
    'IDENTITY' => true,
  ),
  'id_categoria' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'categoria_grupo',
    'COLUMN_NAME' => 'id_categoria',
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
  'id_grupo' => 
  array (
    'SCHEMA_NAME' => 'public',
    'TABLE_NAME' => 'categoria_grupo',
    'COLUMN_NAME' => 'id_grupo',
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
);

}
?>