<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Modelo de datos principal, de el heredan los demas modelos.
 * @author David Unay Santisteban <slavepens@gamil.com>
 * @package SlaveFramework
 * @version 1.0
 */
class Model {
    
    public function __construct(){
        
    }
    
    public function __get($key) {
		$instance =& Controller::getInstance();
		return $instance->$key;
	}
    
}
