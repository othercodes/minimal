<?php defined('DACCESS') or die ('Acceso restringido!');

/**
 * Gestiona la seguridad de los elemetos de e/s 
 * y ofrece varias funciones de cifrado.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0.20140520
 */
class Security {
    

    function __construct() {
        
    }
    
    /**
     * Devuelve una cadena de $length caracteres aleatoria 
     * @param int $length longitud de caracteres.
     * @return string
     */
    public function newSalt($length = 15) {
        $salt = "";
        $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#%&*?";
        for($i=0;$i<$length;$i++) {
            $salt .= $characters{mt_rand(0,(strlen($characters)-1))};
        }
        return $salt;
    }
    
    /**
     * Comprueba si una cadena de caracteres contiene 
     * caracteres no ASCII
     * @param string $str
     * @return boolean
     */
    public function isASCII($str){
        if(preg_match('/[^\x20-\x7f]/',$str) == 1){
            return TRUE;
        }
        return FALSE;
    }
    
    /**
     * Hashea una contraseña dada usando MD5 y un salt dato
     * @param string $salt 
     * @param string $password
     * @return string
     */
    public function hashPassword($salt,$password){
        $hash = md5(md5($password).$salt);
        return $hash;
    }
}