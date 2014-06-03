<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Allows validate url and redirect requests from users 
 * to the controllers and corresponding methods
 * @author David Unay Santisteban <slavepens@gamil.com>
 * @package SlaveFramework
 * @version 1.0
 */
class Router {
    
    private $_path;
    private $_routes;
    private $_segments;
    private $_address;
    private $_patterns = array(
            '(:str)' => '[a-zA-Z]+',
            '(:int)' => '[0-9]+',
            '(:var)' => '[a-zA-Z0-9]+'
            );
    
    /**
     * Starts the router and import ths paths defined in 
     * includes/router.php file  
     */
    public function __construct() {
        if(!@require INCLUDE_PATH."routes.php"){
           echo "Error loading routes.php";
        }
        $this->_routes = $route;
        
        if (isset($_GET['uri'])){
           $this->_path = $_GET['uri'];
        } else {
            $this->_path = $this->_routes['default_controller'];
        }
        
        if(substr($this->_path,-1) == "/"){
           $this->_path = substr($this->_path,0,-1); 
        }
    }
    
    /**
     * Configure if the offline state
     */
    public function configure(){
        if(Application::loadConfig('offline') == 1){
            $this->_path = $this->_routes['default_offline'];
            return;
        }
    }
    
    /**
     * Validates whether the entered path is accepted by the system, 
     * replacing the "wildcard" for regular expressions to 
     * interpret dynamic routes.
     * @return
     */
    public function match() {
        
        $this->_tmp = explode("/", $this->_path);
        foreach ($this->_routes as $ruta => $direccion) {
            
            foreach($this->_patterns as $wildCard => $pattern){
                $ruta = str_replace($wildCard, $pattern, $ruta);
            }
            $ruta = str_replace('/', "\/", $ruta);

            $ruta = "/^".$ruta."$/";
            
            if(preg_match($ruta, $this->_path)){
                
                $indiceReemplazo = 1;
                
                for($i=2;$i<count($this->_tmp);$i++){
                    if(isset($this->_tmp[$i])){ 
                        $direccion = str_replace("$".$indiceReemplazo, $this->_tmp[$i], $direccion);
                    } else {
                        $direccion = $this->_routes[$this->_path];
                    }
                    
                    $indiceReemplazo++;
                }
                $this->_path = $direccion;
                return;
            }
        }
        $this->_path = $this->_routes['default_404'];
    }
    
    /**
     * Segments the final route for subsequent routing
     */
    public function segment(){
        $this->_segments = explode("/", $this->_path);
    }
    
    /**
     * I set the system to call a driver, as with 
     * a given method, with its parameters, if any.
     * @return array
     */
    public function dispatch() {
        if(isset($this->_segments[0])){
            $this->_address['controller'] = $this->_segments[0];
        }
        if(isset($this->_segments[1])){
            $this->_address['method'] = $this->_segments[1];
        }
        for($i=2;$i<count($this->_segments)+2;$i++){
            if(isset($this->_segments[$i])){
                $this->_address['args'][] = $this->_segments[$i];
            }
        }
        return $this->_address;
    }

}