<?php defined('DACCESS') or die ('Acceso restringido!');

/**
 * Check if files in a directory have been altered.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @copyright (c) 2014, David Unay Santisteban
 */
class integrity {
    
    protected $_path;
    protected $_tree = array();
    
    /**
     * Class constructor.
     * @param string $path
     */
    public function __construct($path = null) {
        $this->setPath($path);
    }
    
    /**
     * Set the path.
     * @param string $path
     */
    public function setPath($path = null){
        if(!$path){
            $path = "/";
        }
        if(substr($path,-1) != "/"){
           $this->_path = $path."/"; 
        } else {
            $this->_path = $path;
        }
    }
    
    /**
     * Check the MD5 file signatures and crosses with file 
     * given for diff.
     * @param string $file filename
     * @return array 
     */
    public function checkMD5Hashes($file){
        if (!is_readable($file)) {
            return FALSE;
        }
        $file = file($file);
        $hashes = array();
        foreach ($file as $line) {
            $temp = explode(' ', $line);
            $hashes[trim($temp[1])] = $temp[0];
        }
        $modifies = array();
        $this->_getFileList();
        /* search added files */
        foreach($this->_tree as $key => $value){
            if(!array_key_exists($key, $hashes)) {
                $modifies[] = $this->_getFileStats($key,'added');  
            }
        }
        /* search deleted files */
        foreach($hashes as $key => $value){            
            if(!array_key_exists($key, $this->_tree)) {
                $modifies[] = $this->_reportFileMissing($key); 
            }
        }
        /* search modified files */
        foreach($this->_tree as $key => $value){
            if(array_key_exists($key, $hashes)) {
                if($value != $hashes[$key]){
                    $modifies[] = $this->_getFileStats($key,'modified');
                }
            }
        }
        
        return $modifies; 
    }   
    
    /**
     * Generate a file with md5 signature of the files 
     * of the given directory.
     * @param string $file
     * @return boolean
     */
    public function getMD5Hashes($file = null){
        if(!isset($file)){
            $file = "md5".DS.date('YmdHis').".md5";
        }
        $hashes = '';
        $this->_getFileList();
        foreach ($this->_tree as $key => $value){
            $hashes .= $value." ".$key."\n";
        }
        return file_put_contents($file, $hashes);
    }
    
    /**
     * Generate an array with path, name and signature of each file MD5 
     * in the entered path.
     * @param string $path
     * @return boolean
     */
    private function _getFileList($path = null){
        if(!$path){
            $path = $this->_path;
        }
        if(!is_dir($path)){
            return FALSE;
        }
        $root = opendir($path);
        while($entry = readdir($root)) {
            if ($entry != "." && $entry != "..") {
                if (is_dir($path.$entry)){
                    $this->_getFileList($path.$entry."/");
                } else {
                    $this->_tree[str_replace($this->_path,"",$path.$entry)] = md5_file($path.$entry);
                }
            } 
        }
        closedir($root);
        return $this->_tree;
    }
    
    /**
     * Get the metadata for a given file.
     * @param string $file
     * @return array
     */
    private function _getFileStats($file,$stat){
        if(is_readable($this->_path.$file)) {
            $mdata = stat($this->_path.$file);
            return array(
                'filename' => $file,
                'stat' => $stat,
                'uid' => $mdata[4], 
                'gid' => $mdata[5], 
                'size' => $mdata[7],
                'lastAccess' => date('Y-m-d H:i:s',$mdata[8]),
                'lastModification' => date('Y-m-d H:i:s',$mdata[9])
            ); 
        }
    }
    
    /**
     * Declares a file as deleted.
     * @params string $file
     * @return array
     */
    private function _reportFileMissing($file){
        return array(
            'filename' => $file,
            'stat' => 'deleted',
            'uid' => null, 
            'gid' => null, 
            'size' => null,
            'lastAccess' => null,
            'lastModification' => null
        );
    }
}