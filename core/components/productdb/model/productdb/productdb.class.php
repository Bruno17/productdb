<?php

/**
* productdb
*
* @author Bruno Perner
*
*
* @package productdb
*/
/**
* @package productdb
* @subpackage productdb
*/
class Productdb {
    /**
    * @access public
    * @var modX A reference to the modX object.
    */
    public $modx = null;
    /**
    * @access public
    * @var array A collection of properties to adjust Productdb behaviour.
    */
    public $config = array();

    /**
    * The Productdb Constructor.
    *
    * This method is used to create a new Productdb object.
    *
    * @param modX &$modx A reference to the modX object.
    * @param array $config A collection of properties that modify Productdb
    * behaviour.
    * @return Productdb A unique Productdb instance.
    */
    function __construct(modX & $modx, array $config = array()) {
        $this->modx = & $modx;

        /* allows you to set paths in different environments
        * this allows for easier SVN management of files
        */
        $corePath = $this->modx->getOption('productdb.core_path', null, $modx->getOption('core_path') . 'components/productdb/');
        $assetsPath = $this->modx->getOption('productdb.assets_path', null, $modx->getOption('assets_path') . 'components/productdb/');
        $assetsUrl = $this->modx->getOption('productdb.assets_url', null, $modx->getOption('assets_url') . 'components/productdb/');

        $defaultconfig['debugUser'] = '';
        $defaultconfig['corePath'] = $corePath;
        $defaultconfig['modelPath'] = $corePath . 'model/';
        $defaultconfig['processorsPath'] = $corePath . 'processors/';
        $defaultconfig['templatesPath'] = $corePath . 'templates/';
        $defaultconfig['controllersPath'] = $corePath . 'controllers/';
        $defaultconfig['chunksPath'] = $corePath . 'elements/chunks/';
        $defaultconfig['snippetsPath'] = $corePath . 'elements/snippets/';
        $defaultconfig['baseUrl'] = $assetsUrl;
        $defaultconfig['cssUrl'] = $assetsUrl . 'css/';
        $defaultconfig['jsUrl'] = $assetsUrl . 'js/';
        $defaultconfig['jsPath'] = $assetsPath . 'js/';
        $defaultconfig['connectorUrl'] = $assetsUrl . 'connector.php';
        $defaultconfig['request'] = $_REQUEST;

        $this->config = array_merge($defaultconfig, $config);

        /* load debugging settings */
        if ($this->modx->getOption('debug', $this->config, false)) {
            error_reporting(E_ALL);
            ini_set('display_errors', true);
            $this->modx->setLogTarget('HTML');
            $this->modx->setLogLevel(modX::LOG_LEVEL_ERROR);

            $debugUser = $this->config['debugUser'] == '' ? $this->modx->user->get('username') : 'anonymous';
            $user = $this->modx->getObject('modUser', array('username' => $debugUser));
            if ($user == null) {
                $this->modx->user->set('id', $this->modx->getOption('debugUserId', $this->config, 1));
                $this->modx->user->set('username', $debugUser);
            }
            else {
                $this->modx->user = $user;
            }
        }
    }

    public function aftersave_formtabs($scriptProperties) {
        $modx = & $this->modx;
        $object = & $modx->getOption('object', $scriptProperties, null); //reference to the saved object
        $properties = $modx->getOption('scriptProperties', $scriptProperties, array()); //the processors scriptProperties
        $postvalues = $modx->getOption('postvalues', $scriptProperties, array()); //the posted values

        $fields = json_decode($object->get('fields'), 1);
        $type = $object->get('type');

        $result = array();

        $xpdo = & $object->xpdo;
        $manager = $xpdo->getManager();
        $generator = $manager->getGenerator();

        //$xpdo->addPackage($packageName, $modelpath, $prefix);
        $pkgman = $modx->migx->loadPackageManager();
        $pkgman->xpdo2 = & $xpdo;
        $pkgman->manager = $xpdo->getManager();
        //$pkgman->parseSchema($schemafile, $modelpath, true);
        $modfields = array();
        switch ($type) {
            case 'global' :
                $class = 'productdbFlatRow';
                break;
            case 'translations' :
                $class = 'productdbTranslationRow';
                break;
        }

        $this->prepareFieldMeta($class, $xpdo, $fields);

        $pkgman->alterFields($class, $modfields);
        $pkgman->addMissingFields($class, $modfields);

        return $modx->toJson($result);

    }

    public function OnModxInit($scriptProperties = array()) {
        $modx = & $this->modx;
        $migx = $modx->getService('migx', 'Migx', $modx->getOption('migx.core_path', null, $modx->getOption('core_path') . 'components/migx/') . 'model/migx/', $scriptProperties);
        if (!($migx instanceof Migx))
            return '';
        $properties = array();
        $properties['packageName'] = 'productdb';

        $xpdo = $migx->getXpdoInstanceAndAddPackage($properties);

        $fields = null;

        $c = $xpdo->newQuery('productdbFormtabs');
        if ($collection = $xpdo->getCollection('productdbFormtabs', $c)) {
            foreach ($collection as $object) {
                $fields = json_decode($object->get('fields'), 1);
                $type = $object->get('type');

                switch ($type) {
                    case 'global' :
                        $class = 'productdbFlatRow';
                        break;
                    case 'translations' :
                        $class = 'productdbTranslationRow';
                        break;
                }
                $this->prepareFieldMeta($class, $xpdo, $fields);

            }
        }

        /*
        if ($chunk = $modx->getObject('modChunk',array('name'=>'debug'))){
        $chunk->set('content', 'test' . $name .  print_r($fields,1));
        $chunk->save();
        }
        */
    }

    public function prepareFieldMeta($class, $xpdo, $fields) {
        $xpdo->loadClass($class);

        if (is_array($fields)) {
            foreach ($fields as $field) {
                $fieldname = isset($field['field']) ? $field['field'] : '';

                $xpdo->map[$class]['fields'][$fieldname] = 0;
                $fieldmeta = array();
                $fieldmeta['dbtype'] = $field['dbtype'];
                if (!empty($field['precision'])) {
                    $fieldmeta['precision'] = $field['precision'];
                }
                $fieldmeta['phptype'] = $field['phptype'];
                $fieldmeta['null'] = false;
                $fieldmeta['default'] = $field['phptype'] == 'string' ? '' : 0;

                $xpdo->map[$class]['fieldMeta'][$fieldname] = $fieldmeta;
            }
        }
    }

}
