<?php defined('DACCESS') or die ('Acceso restringido!');

error_reporting(E_ALL);

/**
 * Definition of system paths.
 */
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));

/* main system paths */
define('CONFIGURATION_PATH', ROOT . DS . 'configuration' . DS);
define('LIBRARIES_PATH', ROOT . DS . 'libraries' . DS);
define('INCLUDE_PATH', ROOT . DS . 'includes' . DS);
define('SYSTEM_PATH', ROOT . DS . 'system' . DS);
define('CTRLS_PATH', ROOT . DS . 'controllers' . DS);
define('MODLS_PATH', ROOT . DS . 'models' . DS);
define('VIEWS_PATH', ROOT . DS . 'views' . DS);
define('LANG_PATH', ROOT . DS . 'languages' . DS);

/**
 * Composer autoload
 */
include_once "vendor/autoload.php";