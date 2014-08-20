<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * System Log
 * @author David Unay Santisteban <slavepens@gamil.com>
 * @package SlaveFramework
 * @subpackage System
 * @version 1.0
 */
class Logger {
    
    private $_folder;
    private $_file = 'system.log';
    
    /**
     * Logger class constructor, create the system.log file in the 
     * directory set in the config file.
     */
    public function __construct() {
        $this->_folder = Application::loadConfig('log_path');
        if(!is_readable($this->_folder.DS.$this->_file)){
            file_put_contents($this->_folder.DS.$this->_file,'');
        }
    }
    
    /**
     * Return the logs messages.
     * @return type
     */
    public function getLog(){
        if(!is_readable($this->_folder.DS.$this->_file)){
            $log = file_get_contents($this->_folder.DS.$this->_file);
        }
        return $log;
    }
    
    /**
     * Append a new log message inte the system.log file
     * @param type $message
     */
    public function log($message){
        $message = date("Y-m-d H:i:s")." ".$message."\n";
        $bytes = file_put_contents($this->_folder.DS.$this->_file, $message, FILE_APPEND);
        if($bytes <= 0){
            echo "Cannot write to ".$this->_file;
        }
    }
     
}

