<?php
$object = &$modx->getOption('object', $scriptProperties, null); //reference to the saved object
$properties = $modx->getOption('scriptProperties', $scriptProperties, array()); //the processors scriptProperties
$postvalues = $modx->getOption('postvalues', $scriptProperties, array()); //the posted values

$fields = json_decode($object->get('fields'), 1);
$result = array();
$xpdo = &$object->xpdo;

$c = $xpdo->getCollection('productdbFormtabs');
if ($collection = $xpdo->getCollection('productdbFormtabs',$c)){
    foreach ($collection as $formtab_object){
        $search = array();
        $search['product_id'] = $object->get('id');
        $classname = 'productdbFlatRow';
        if ($related_object = $xpdo->getObject($classname,$search)){
            
        } else {
            $related_object = $xpdo->newObject($classname);
            $related_object->fromArray($search);
        }
        
        $fields = json_decode($formtab_object->get('fields'),1);
        if (is_array($fields)){
            foreach ($fields as $field){
                $fieldname = isset($field['field']) ? 'FlatRow_' . $field['field'] : '';
                $field = isset($field['field']) ? $field['field'] : '';
                $related_object->set($field,$object->get($fieldname));
            }
            $related_object->save();
        }
    }
}


return $modx->toJson($result);