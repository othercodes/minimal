<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Definiciones de las rutas del sistema.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */
defined('DACCESS') or die('Acceso restringido!');

/* definimos el separador del sistema. */
define('DS', DIRECTORY_SEPARATOR);
/* definimos la ruta de la web. */
define('ROOT', dirname(dirname(__FILE__)));

/* definimos las rutas del sistema. */
define ('INCLUDE_PATH', ROOT.DS.'includes'.DS);
define ('SYSTEM_PATH', ROOT.DS.'system'.DS);
define ('CTRLS_PATH', ROOT.DS.'controllers'.DS);
define ('MODLS_PATH', ROOT.DS.'models'.DS);
define ('VIEWS_PATH', ROOT.DS.'views'.DS);
define ('LANG_PATH', ROOT.DS.'languages'.DS);