<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Definition of the url access.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */

$this->get('default_controller', 'home');
$this->get('default_404', 'notfound');
$this->get('default_offline', 'offline');

$this->get('home', 'demo');
$this->get('offline', 'offline');