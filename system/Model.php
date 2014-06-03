<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Main data model, inherited from the other models.
 * @author David Unay Santisteban <slavepens@gamil.com>
 * @package SlaveFramework
 * @version 1.0
 */
class Model {
    
    public function __construct(){
        //do something
    }
    
    /**
     * Return the property of the main controller.
     * @param type $key
     * @return type
     */
    public function __get($key) {
		$instance =& Controller::getInstance();
		return $instance->$key;
	}
    
}
