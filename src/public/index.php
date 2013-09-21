<?php
/**
 * Vassilymas
 *
 * @license - $License: http://www.gnu.org/licenses/gpl.txt $
 *
 * @author - $Author: enkil2003 $
 * @date - $Date: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @filesource - $HeadURL: http://subversion.assembla.com/svn/vassilymas/trunk/application/controllers/CatalogController.php $
 * @revision - $Revision: 321 $
 * 
 * @LastChangedBy $LastChangedBy: enkil2003 $
 * @lastChangedDate - $LastChangedDate: 2011-12-31 02:14:39 -0300 (Sat, 31 Dec 2011) $
 * 
 * @copyright - Copyright: (c) 2011 and future, Ricardo Buquet
 */
if (strpos($_SERVER['HTTP_HOST'], 'local')) {
    // Define path to application content delivery network
    defined('APPLICATION_CDN')
            || define('APPLICATION_CDN', 'http://www.staticvassilymas.local');
} else {
    defined('APPLICATION_CDN')
            || define('APPLICATION_CDN', 'http://www.staticvassilymas.com.ar');
}

// Define path to application content delivery network
defined('APPLICATION_DEFAULT_ENCODING')
    || define('APPLICATION_DEFAULT_ENCODING', 'utf-8');

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    '.',
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/../library/PEAR'),
    APPLICATION_PATH . '/../library/Doctrine-V.1.2.4',
    APPLICATION_PATH . '/../models',
    APPLICATION_PATH . '/../models/base',
    APPLICATION_PATH . '/Service',
    //get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();