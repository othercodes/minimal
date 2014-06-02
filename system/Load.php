<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Se encarga de cargar las libreiras, modelos y vistas, bajo peticion demanda
 * del controlador definido por usuario.
 * @author David Unay Santisteban <slavepens@gamil.com>
 * @package SlaveFramework
 * @version 1.0
 */
class Load {
    
    
    public function __construct() {
    
    }
    
    /**
     * Importa el modelo de datos elegido
     * @param type $model
     */
    public function model($model){
        if(!@include MODLS_PATH.$model.".php"){
            echo "Error loading ".$model." model";
        }
        $instance =& Controller::getInstance();
        $instance->$model = new $model();
    }
    
    /**
     * Carga la vista elegida con los datos del modelo.
     * @param type $view vista a mostrar.
     * @param type $data datos a mostrar
     */
    public function view($view,$data = array()){
        return $this->nexus(array('views' => $view, 'vars' => $data));
    }
    
    /**
     * 
     * @param type $traverse
     */
    public function nexus($traverse){
        
        $instance =& Controller::getInstance();
        
		foreach (get_object_vars($instance) as $_sl_key => $_sl_var) {
            
			if (!isset($this->buffer)) { 
				$this->$_sl_key =& $instance->$_sl_key;
                
			}
            
		}
        
        ob_start();
        if(isset($traverse['vars'])){
            foreach($traverse['vars'] as $key => $value){
                $$key = $value;
            }
        }
        
        if(!@include VIEWS_PATH.$traverse['views'].".php"){
            echo "Erro loading ".$traverse['views']." view";
        }
        
        $instance->buffer .= ob_get_clean();
    }
    

}