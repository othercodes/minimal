<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Definition of the url access. 
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */

/* Default routes, DO NOT DELETE!!! */
$route['default_controller'] = 'home';
$route['default_404'] = 'notfound';
$route['default_offline'] = 'offline';
/* user-defined routes */
$route['home'] = 'demo';
$route['demo/api/(:str)'] = array('demo/api/$1','POST');