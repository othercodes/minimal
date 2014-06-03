<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Main application controller, this inherited all other drivers.
 * @author David Unay Santisteban <slavepens@gamil.com>
 * @package SlaveFramework
 * @version 1.0
 */
class Controller {
    
    private static $instance;
    
    /**
     * Constructor of the main Controller.
     */
    public function __construct() {
        self::$instance =& $this;
        // init the dinamic loader
        $this->load =& Application::loadClass('Load', SYSTEM_PATH);
        // import the autoload list
        if(!@require INCLUDE_PATH."autoload.php"){
            echo "Error loading autoload.php";
        }
        // load the default classes
        if(count($classes)>0){
            foreach($classes as $class => $directory ){
                $object = strtolower($class);
                $this->$object = Application::loadClass($class, $directory);
            }
        }
    }
    
    /**
     * Return the controller instance.
     * @return object 
     */
    public static function &getInstance(){
		return self::$instance;
	}  
   
}
