<?php
error_reporting(-1);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));
 
define('TESTS_PATH', dirname(__FILE__));
define('TMP_DIR', sys_get_temp_dir());
// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/../library/PEAR'),
    realpath(APPLICATION_PATH . '/../library/Doctrine-V.1.2.4'),
    realpath(APPLICATION_PATH . '/models'),
    realpath(APPLICATION_PATH . '/models/base'),
    realpath(APPLICATION_PATH . '/../library/Vassilymas/Service'),
    get_include_path()
)));
 
ini_set('memory_limit', '512M');
/**
 * Register autoloader
 */
require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance()
    ->registerNamespace('Vassilymas_')
    ->registerNamespace('My_')
    ->registerNamespace('Doctrine')
    ->pushAutoloader(array('Doctrine', 'autoload'));
    
$config = new Zend_Config_Ini(
    APPLICATION_PATH . '/configs/application.ini',
    APPLICATION_ENV
);

new Zend_Loader_Autoloader_Resource ($config->resources->Autoloader);
$manager = Doctrine_Manager::getInstance();
foreach ($config->doctrine->attr as $key => $val) {
    $manager->setAttribute(constant("Doctrine::$key"), $val);
}
$conn = Doctrine_Manager::connection($config->doctrine->dsn, 'doctrine');
$conn->setCharset('utf8');
Doctrine::loadModels($config->doctrine->models_path->toArray());

Zend_Session::$_unitTestEnabled = true;
Zend_Session::start();
require_once APPLICATION_PATH . '/../tests/application/ControllerTestCase.php';
