<?php defined('DACCESS') or die ('Acceso restringido!');

/**
 * Control de datos de entrada.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */

class Input {
    
    function __construct() {

    }
    
    /**
     * Permite obtener los datos mediante el metodo POST
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
     * Permite obtener los datos mediante el metodo POST
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