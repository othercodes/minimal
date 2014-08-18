<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Bootstrap Class
 * @author David Unay Santisteban <slavepens@gamil.com>
 * @package SlaveFramework
 * @version 1.0
 */
class Application {
    
    protected $_config;
    private $_router;
    private $_controller;
    private $_datagram = array();
    private $_cache;
    
    /**
     * App contructor.
     */
    public function __construct() {
        $this->_router = $this->loadClass('Router', SYSTEM_PATH);
        mb_internal_encoding(self::loadConfig('encoding'));
        session_start();
    }
    
    /**
     * Route the app to get the controller, method and arguments
     * to execute.
     */
    public function route(){
        $this->_router->configure();
        $this->_router->match();
        $this->_router->segment();
        $this->_datagram = $this->_router->dispatch();
    }
    
    /**
     * Loads the specified controller and methods 
     * with arguments by the router.
     */
    public function dispatch(){
        if(!@include_once CTRLS_PATH.$this->_datagram['controller'].'.php'){
            echo "Error loading ".$this->_datagram['controller']." controller";
        }
        
        $class = ucfirst($this->_datagram['controller']);
        $this->_controller = new $class();
        
        if(isset($this->_datagram['method'])){
            $method = $this->_datagram['method'];
        } else {
            //default method
            $method = 'index';
        }

        if(method_exists($class,$method)){
            if(isset($this->_datagram['args'])){
                $args = $this->_datagram['args'];
            } else {
                $args = array(null);
            }
            // ejecutamos el metodo con sus argumentos, si es que existen.
            call_user_func_array(array($this->_controller,$method),$args);
        } 
    }
    
    /**
     * Render the app.
     */
    public function render(){
        print $this->_controller->buffer;
    }
    
    /**
     * Is responsible for initiating each class as property 
     * allowing the controller to use it from 
     * any part of the application as a super object.
     * @param string $class
     * @param string $directory
     * @return object
     */
    public static function loadClass($class,$directory){
        if(!@include_once $directory.DS.$class.'.php'){
            echo "Error loading ".$class.".php class.";
        }
        return new $class();
    }
    
    /**
     * Return the requested config value.
     * @param string $key config key.
     * @return mixed
     */
    public static function loadConfig($key){
        if(!@include_once INCLUDE_PATH."config.php"){
            echo "Error loading config file.";
        }
        $cfg = new Config();
        return $cfg->$key;
    }
}
