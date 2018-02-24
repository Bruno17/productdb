<?php
$object = &$modx->getOption('object', $scriptProperties, null); //reference to the saved object
$properties = $modx->getOption('scriptProperties', $scriptProperties, array()); //the processors scriptProperties
$postvalues = $modx->getOption('postvalues', $scriptProperties, array()); //the posted values

$fields = json_decode($object->get('fields'), 1);
$type = $object->get('type');

$result = array();

$xpdo = &$object->xpdo;
$manager = $xpdo->getManager();
$generator = $manager->getGenerator();

//$xpdo->addPackage($packageName, $modelpath, $prefix);
$pkgman = $modx->migx->loadPackageManager();
$pkgman->xpdo2 = &$xpdo;
$pkgman->manager = $xpdo->getManager();
//$pkgman->parseSchema($schemafile, $modelpath, true);
$modfields = array();
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


$pkgman->addMissingFields($class, $modfields);


return $modx->toJson($result);