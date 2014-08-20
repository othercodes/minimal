<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Is responsible for loading the libraries, models and views, on demand request 
 * controller defined by user.
 * @author David Unay Santisteban <slavepens@gamil.com>
 * @package SlaveFramework
 * @subpackage System
 * @version 1.0
 */
class Load {
    
    
    public function __construct() {
        //do something
    }
    
    /**
     * Import the chosen data model.
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
     * Loads the selected view and import data.
     * @param type $view
     * @param type $data
     */
    public function view($view,$data = array()){
        return $this->nexus(array('views' => $view, 'vars' => $data));
    }
    
    /**
     * Allow to the app to join data with the views
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