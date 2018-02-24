<?php
$migx = $modx->getService('migx', 'Migx', $modx->getOption('migx.core_path', null, $modx->getOption('core_path') . 'components/migx/') . 'model/migx/', $scriptProperties);
if (!($migx instanceof Migx))
    return '';
$properties = array();
$properties['packageName'] = 'productdb';
$xpdo = $migx->getXpdoInstanceAndAddPackage($properties);

$fields = null;

$c = $xpdo->newQuery('productdbFormtabs');
if ($collection = $xpdo->getCollection('productdbFormtabs',$c)){
    foreach ($collection as $object){
        $fields = json_decode($object->get('fields'), 1);  
        $type = $object->get('type');
        
        switch ($type){
            case 'global':
                $class = 'productdbFlatRow';    
            break;
            case 'translations':
                $class = 'productdbTranslationRow';    
            break;    
        }
        $xpdo->loadClass($class);

        if (is_array($fields)) {
            foreach ($fields as $field) {
                $fieldname = isset($field['field']) ? $field['field'] : '';
        
                $xpdo->map[$class]['fields'][$fieldname] = 0;
                $xpdo->map[$class]['fieldMeta'][$fieldname] = array(
                    'dbtype' => 'varchar',
                    'precision' => 255,
                    'phptype' => 'string',
                    'null' => false,
                    'default' => '',
                );
            }
        }        
        
    }
}

/*
if ($chunk = $modx->getObject('modChunk',array('name'=>'debug'))){
    $chunk->set('content', 'test' . $name .  print_r($fields,1));
    $chunk->save();
}
*/