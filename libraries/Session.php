<?php defined('DACCESS') or die ('Acceso restringido!');

/**
 * Manages interactions with $ _SESSION variable
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */
class Session {
    
    public function __construct() {
        
    }
    
    /**
     * Gets the values ​​stored in a session variable.
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
     * Set a session variable.
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
     * Returns the session ID.
     * @param string $id
     * @return string
     */
    public function sessionId($id = null){
        return session_id($id);
    }
    
    /**
     * Returns the session state.
     * @return array
     */
    public function sessionStatus(){
        return session_status();
    }
    
    /**
     * Purge custom session variables.
     * @return boolean
     */
    public function sessionPurge(){
        return session_unset();
    }
    
    /**
     * Destroy the FULL session.
     * @return boolean
     */
    public function sessionDestroy(){
        return session_destroy();
    }
    
}
