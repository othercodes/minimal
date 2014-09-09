<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * System Cache
 * @author David Unay Santisteban <slavepens@gamil.com>
 * @package SlaveFramework
 * @subpackage System
 * @version 1.0
 */
class Cache {

    private $_folder;
    private $_cachetime;
    private $_cachefile;
    
    public $showcache;
    public $enable;
    
    /**
     * Constructor class
     */
    public function __construct() {
        $this->enable = Application::loadConfig('cache');
        $this->_folder = Application::loadConfig('cache_path');
        $this->_cachetime = Application::loadConfig('cache_time');
    }
    
    /**
     * Check the life of the cache file
     * @param type $page
     */
    public function check($page){
        
        $this->_cachefile = $this->_folder.DS.str_replace(DS, "-", $page).".html";

        if(is_readable($this->_cachefile) && time() - $this->_cachetime < filemtime($this->_cachefile)){
            // mostrar cache
            $this->showcache = TRUE;
        } else {
            // generar cache
            $this->showcache = FALSE;
        }
    }
    
    /**
     * Return the cache to the client.
     * @return type
     */
    public function dump(){
        if($this->showcache){
            return $this->getCache();
        } else {
            return $this->generateCache();
        }
    }
    
    /**
     * Generate a new cache file from the buffer of the controller.
     * @return string
     */
    private function generateCache(){
        $instance =& Controller::getInstance();
        $size = file_put_contents($this->_cachefile, $instance->buffer);
        if($size > 0) {
            return file_get_contents($this->_cachefile);
        } else {
            die ("Error writing to cache file.");
        }
    }
    
    /**
     * Return file content from a cache file.
     * @return type
     */
    private function getCache(){
        return file_get_contents($this->_cachefile);
    }
}

