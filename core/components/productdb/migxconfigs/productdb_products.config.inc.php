<?php
$config = $this->customconfigs;

if (!empty($config['packageName'])) {
    $packageNames = explode(',', $config['packageName']);
    $packageName = isset($packageNames[0]) ? $packageNames[0] : '';

    if (count($packageNames) == '1') {
        //for now connecting also to foreign databases, only with one package by default possible
        $xpdo = $this->modx->migx->getXpdoInstanceAndAddPackage($config);
    }
    else {
        //all packages must have the same prefix for now!
        foreach ($packageNames as $packageName) {
            $packagepath = $this->modx->getOption('core_path') . 'components/' . $packageName . '/';
            $modelpath = $packagepath . 'model/';
            if (is_dir($modelpath)) {
                $this->modx->addPackage($packageName, $modelpath, $prefix);
            }

        }
        $xpdo = & $this->modx;
    }
    if ($this->modx->lexicon) {
        $this->modx->lexicon->load($packageName . ':default');
    }
}
else {
    $xpdo = & $this->modx;
}

$tabs = $this->customconfigs['tabs'];

$c = $xpdo->newQuery('productdbFormtabs');
$c->where(array('type' => 'global'));
if ($collection = $xpdo->getCollection('productdbFormtabs', $c)) {
    foreach ($collection as $object) {
        $tab = array();
        $tab['caption'] = $object->get('name');
        $tab['fields'] = array();
        $fields = json_decode($object->get('fields'), 1);
        if (is_array($fields)) {
            foreach ($fields as $field) {
                $formfield = array();
                $formfield['field'] = isset($field['field']) ? 'FlatRow_' . $field['field'] : '';
                $formfield['caption'] = isset($field['caption']) ? $field['caption'] : '';
                $tab['fields'][] = $formfield;
            }

        }
        $tabs[] = $tab;
    }
}

$joins = json_decode($this->customconfigs['joins'],1);

$c = $xpdo->newQuery('productdbLang');
$c->where(array('published' => 1));
if ($lang_collection = $xpdo->getCollection('productdbLang', $c)) {
    foreach ($lang_collection as $lang_o) {
        $lang_key = $lang_o->get('lang_key');
        $language = $lang_o->get('language');

        $join = array();
        $join['alias'] = 'Trans_' . $lang_key;
        $join['classname'] = 'productdbTranslationRow';
        $join['on'] = $join['alias'] . '.product_id=productdbRow.id AND ' . $join['alias'] . '.lang_key="' . $lang_key . '"';
        $joins[] = $join;

        $c = $xpdo->newQuery('productdbFormtabs');
        $c->where(array('type' => 'translations'));
        if ($collection = $xpdo->getCollection('productdbFormtabs', $c)) {
            foreach ($collection as $object) {
                $tab = array();
                $tab['caption'] = $object->get('name') . ' ' . $language;
                $tab['fields'] = array();
                $fields = json_decode($object->get('fields'), 1);
                if (is_array($fields)) {
                    foreach ($fields as $field) {
                        $formfield = array();
                        $formfield['field'] = isset($field['field']) ? 'Trans_' . $lang_key . '_' . $field['field']  : '';
                        $formfield['caption'] = isset($field['caption']) ? $field['caption'] : '';
                        $tab['fields'][] = $formfield;
                    }

                }
                $tabs[] = $tab;
            }
        }
    }
}

//print_r($joins);

$this->customconfigs['joins'] = json_encode($joins);

//$this->customconfigs['win_id'] = 'migxformtabfields';
$this->customconfigs['tabs'] = $tabs;
//$this->customconfigs['columns'] = $this->modx->fromJson($columns);
