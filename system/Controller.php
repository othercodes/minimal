<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Controlador Principal de la aplicaicon, de este heredaran 
 * todos los demas controladores.
 * @author David Unay Santisteban <slavepens@gamil.com>
 * @package SlaveFramework
 * @version 1.0
 */
class Controller {
    
    private static $instance;
    
    /**
     * Contruimos el Controlador Principal, en el cual se 
     * precargaran varias clases propias del sistema.
     */
    public function __construct() {
        self::$instance =& $this;
        // iniciamos el cargador dinamico.
        $this->load =& Application::loadClass('Load', 'system');
        
        require INCLUDE_PATH."autoload.php";
        
        if(count($classes)>0){
            foreach($classes as $class => $directory ){
                $object = strtolower($class);
                $this->$object = Application::loadClass($class, $directory);
            }
        }
    }
    
    /**
     * Devuelve la instancia actual del controlador.
     * @return object 
     */
    public static function &getInstance(){
		return self::$instance;
	}  
   
}
