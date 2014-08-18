<?php defined('DACCESS') or die ('Acceso restringido!');

/**
 * Input control class.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */

class Input {
    
    function __construct() {
        //do something
    }
    
    /**
     * Get data from POST method
     * @param string $index
     * @return mixed
     */
    public function post($index = null){
        $post = array();
        foreach($_POST as $key => $value){
            $post[$key] = $value;
        }
        if($index){
            return $post[$index];
        }
        return $post;
    }
    
    /**
     * Get data from GET method
     * @param string $index
     * @return mixed
     */
    public function get($index = null){
        $get = array();
        foreach($_GET as $key => $value){
            $get[$key] = $value;
        }
        if($index){
            return $get[$index];
        }
        return $get;
    }
}