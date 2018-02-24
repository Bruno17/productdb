<?php
$xpdo_meta_map['productdbTranslationRow']= array (
  'package' => 'productdb',
  'version' => '1.1',
  'table' => 'productdb_translation_rows',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'MyISAM',
  ),
  'fields' => 
  array (
    'product_id' => NULL,
    'lang_key' => '',
  ),
  'fieldMeta' => 
  array (
    'product_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'index' => 'index',
    ),
    'lang_key' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '10',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
      'index' => 'index',
    ),
  ),
  'aggregates' => 
  array (
    'Product' => 
    array (
      'class' => 'productdbRow',
      'local' => 'product_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'local',
    ),
  ),
);
