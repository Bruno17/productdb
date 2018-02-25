<?php
$productdb = $modx->getService('productdb', 'Productdb', $modx->getOption('productdb.core_path', null, $modx->getOption('core_path') . 'components/productdb/') . 'model/productdb/', $scriptProperties);
if (!($productdb instanceof Productdb))
    return '';
    
return $productdb->OnModxInit();