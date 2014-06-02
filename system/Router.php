<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Permite validar url y direccionar las peticiones de los usuarios a 
 * los controladores y metodos correspondientes
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
     * Inicia el router, importa las rutas declaradas
     * en el archivo de configuracion (includes/routes.php)
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
     * 
     */
    public function configure($params = null){
        if($params->offline == 1){
            $this->_path = $this->_routes['default_offline'];
            return;
        }
    }
    
    /**
     * Valida si la ruta introducida es aceptada o no por el sistema,
     * reemplazando las "wildcard" por expresiones regulares para 
     * interpretar rutas dinamicas.
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
     * Segmenta la ruta final para su posterior direccionamiento
     */
    public function segment(){
        $this->_segments = explode("/", $this->_path);
    }
    
    /**
     * Establece la direccion final que usara el sistema, es decir
     * configura el sistema para que llame a un controlador, dado con
     * un metodo dado, con sus parametros, si es que existen.
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