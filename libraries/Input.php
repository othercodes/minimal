<?php defined('DACCESS') or die ('Acceso restringido!');

/**
 * Input control class.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @subpackage Libraries
 * @version 1.2
 */

class Input {
    
    private $post = array();
    private $get = array();
    
    /**
     * Dump and sanitize all the POST and GET data
     * in privates variables.
     */
    function __construct() {
        foreach($_POST as $key => $value){
            $this->post[$key] = htmlspecialchars($value, ENT_QUOTES);
        }
        unset($_POST);
        foreach($_GET as $key => $value){
            $this->get[$key] = htmlspecialchars($value, ENT_QUOTES);
        }
        unset($_GET);
    }
    
    /**
     * Filter the post values allowing 
     * only the expected values.
     * @param array $expected
     * @return boolean
     */
    public function expectedPost($expected){
        if(!is_array($expected)){
            return FALSE;
        }
        foreach($this->post as $key => $value){
            if(!in_array($key,$expected)){
                unset($this->post[$key]);
            }
        }
    }
    
    /**
     * Filter the get values allowing 
     * only the expected values.
     * @param array $expected
     * @return boolean
     */
    public function expectedGet($expected){
        if(!is_array($expected)){
            return FALSE;
        }
        foreach($this->post as $key => $value){
            if(!in_array($key,$expected)){
                unset($this->post[$key]);
            }
        }
    }
    
    /**
     * Get data from POST method
     * @param string $index
     * @return mixed
     */
    public function post($index = null){
        if($index){
            return $this->post[$index];
        }
        return $this->post;
    }
    
    /**
     * Get data from GET method
     * @param string $index
     * @return mixed
     */
    public function get($index = null){
        if($index){
            return $this->get[$index];
        }
        return $this->get;
    }
    
    /**
     * Get the json data from the raw input stream.
     * @return mixed
     */
    public function getJsonRequest(){
        return json_decode(file_get_contents('php://input'), true);
    }
}