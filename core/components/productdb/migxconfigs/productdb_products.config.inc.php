<?php

$config = $this->customconfigs;

if (!empty($config['packageName'])) {
    $packageNames = explode(',', $config['packageName']);
    $packageName = isset($packageNames[0]) ? $packageNames[0] : '';

    if (count($packageNames) == '1') {
        //for now connecting also to foreign databases, only with one package by default possible
        $xpdo = $this->modx->migx->getXpdoInstanceAndAddPackage($config);
    } else {
        //all packages must have the same prefix for now!
        foreach ($packageNames as $packageName) {
            $packagepath = $this->modx->getOption('core_path') . 'components/' . $packageName . '/';
            $modelpath = $packagepath . 'model/';
            if (is_dir($modelpath)) {
                $this->modx->addPackage($packageName, $modelpath, $prefix);
            }

        }
        $xpdo = &$this->modx;
    }
    if ($this->modx->lexicon) {
        $this->modx->lexicon->load($packageName . ':default');
    }
} else {
    $xpdo = &$this->modx;
}


$tabs = $this->customconfigs['tabs'];


$c = $xpdo->getCollection('productdbFormtabs');
if ($collection = $xpdo->getCollection('productdbFormtabs',$c)){
    foreach ($collection as $object){
        $tab = array();
        $tab['caption'] = $object->get('name');
        $tab['fields'] = array();
        $fields = json_decode($object->get('fields'),1);
        if (is_array($fields)){
            foreach ($fields as $field){
                $formfield = array();
                $formfield['field'] = isset($field['field']) ? 'FlatRow_' . $field['field'] : '';
                $formfield['caption'] = isset($field['caption']) ? $field['caption'] : '';
                $tab['fields'][] = $formfield;
            }

        }
        $tabs[] = $tab;
    }
}


//$this->customconfigs['win_id'] = 'migxformtabfields';
$this->customconfigs['tabs'] = $tabs;
//$this->customconfigs['columns'] = $this->modx->fromJson($columns);


