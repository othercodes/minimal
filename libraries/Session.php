<?php defined('DACCESS') or die ('Acceso restringido!');

/**
 * Gestiona las interacciones con la variable $_SESSION
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */
class Session {
    
    public function __construct() {
        
    }
    
    /**
     * Obtiene los valores almacenados en una varible de sesion.
     * @param string $index
     * @return mixed
     */
    public function getData($index = null){
        $session = array();
        foreach($_SESSION as $key => $value){
            if(isset($value)){
                $session[$key] = $value;
            }
        }
        if($index){
            return $session[$index];
        }
        return $session;
    }
    
    /**
     * Establece una variable de sesion
     * @param string $index
     * @param mixed $value
     * @return boolean
     */
    public function setData($index,$value){
        if(!isset($index) && !isset($value)){
            return FALSE;
        }
        $_SESSION[$index] = $value;
    }
    
    /**
     * Devuelve el ID de sesion
     * @param string $id
     * @return string
     */
    public function sessionId($id = null){
        return session_id($id);
    }
    
    /**
     * Devuelve el estado de la sesion.
     * @return array
     */
    public function sessionStatus(){
        return session_status();
    }
    
    /**
     * Purga las variables personalizadas de sesion.
     * @return boolean
     */
    public function sessionPurge(){
        return session_unset();
    }
    
    /**
     * Destruye la sesion COMPLETA.
     * @return boolean
     */
    public function sessionDestroy(){
        return session_destroy();
    }
    
}
