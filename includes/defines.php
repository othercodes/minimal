<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Definition of system paths.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */
defined('DACCESS') or die('Acceso restringido!');

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

/* main system paths */
define ('INCLUDE_PATH', ROOT.DS.'includes'.DS);
define ('SYSTEM_PATH', ROOT.DS.'system'.DS);
define ('CTRLS_PATH', ROOT.DS.'controllers'.DS);
define ('MODLS_PATH', ROOT.DS.'models'.DS);
define ('VIEWS_PATH', ROOT.DS.'views'.DS);
define ('LANG_PATH', ROOT.DS.'languages'.DS);