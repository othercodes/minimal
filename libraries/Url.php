<?php defined('DACCESS') or die ('Acceso restringido!');

/**
 * Clase para controlar las url del sistema.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */

class Url {

    public function __construct() {
    
    }
    
    /**
     * Devuelve la URL base del sistema
     * @return string
     */
    public static function basePath(){
        return substr($_SERVER['PHP_SELF'],0,-9);
    }
    
    /**
     * Crea una ruta en base a la URL del sistema
     * @param string $path
     */
    public static function setUrl($path){
        $basepath = self::basePath();
        echo $basepath.$path;
    }

    /**
     * Redirecciona a una ruta dada.
     * @param string $page
     */
    public static function redirect($page){
        $basepath = self::basePath();
        header('Location: '.$basepath.$page);
    }
}

