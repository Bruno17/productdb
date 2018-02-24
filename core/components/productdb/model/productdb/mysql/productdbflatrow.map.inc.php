<?php
$xpdo_meta_map['productdbFlatRow']= array (
  'package' => 'productdb',
  'version' => '1.1',
  'table' => 'productdb_flat_rows',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'MyISAM',
  ),
  'fields' => 
  array (
    'product_id' => NULL,
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
