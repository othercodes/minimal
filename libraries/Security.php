<?php defined('DACCESS') or die ('Acceso restringido!');

/**
 * It offers several security features.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0.20140520
 */
class Security {
    

    function __construct() {
        
    }
    
    /**
     * Returns a string of random characters with $length length. 
     * @param int $length
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
     * Checks if a string contains non ASCII characters
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
     * Hash a password using MD5 and given salt
     * @param string $salt 
     * @param string $password
     * @return string
     */
    public function hashPassword($salt,$password){
        $hash = md5(md5($password).$salt);
        return $hash;
    }
}