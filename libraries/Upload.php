<?php defined('DACCESS') or die ('Acceso restringido!');

/**
 * Managing file uploads to the server.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @subpackage Libraries
 * @version 1.0
 */
class Upload {
    
    private $file = array();
    private $valid = TRUE;
    private $storedDir;
    private $storedFile;
    private $storedFileExt;
    
    /**
     * Class constructor.
     */
    public function __construct() {}
    
    /**
     * Start the upload.
     * @param file $uploadedFile
     */
    public function uploadFile($uploadedFile){
        if($uploadedFile['error'] == 0){
            $this->file = $uploadedFile;
        } else {
            echo $uploadedFile['error'];
        }
    }

    /**
     * Validate the extent, type and file size
     * @param array $allowedSize size in MB
     * @param array $allowedExt valid extension
     * @param array $allowedTypes valid MIME types
     * @return boolean
     */
    public function validate($allowedSize, $allowedExt, $allowedTypes) {
        $sections = explode(".", $this->file['name']);
        $this->storedFileExt = end($sections);
        $allowedSize = $allowedSize * (pow(1024,2));
        if($this->file['size'] > $allowedSize){
            $this->valid = FALSE;
        }
        if(!in_array($this->storedFileExt, $allowedExt)){
            $this->valid = FALSE;
        }
        if(!in_array($this->file['type'], $allowedTypes)){
            $this->valid = FALSE;
        }
        return $this->valid;
    }
    
    /**
     * Save the file in the given directory.
     * @param string $path
     * @return boolean
     */
    public function save($path){
        if($this->valid == TRUE){
            $this->storedDir = $path;
            $this->storedFile = $path.microtime().$this->file['name'];
            if(file_exists($this->storedFile)){
                return FALSE;
            } else {
                move_uploaded_file($this->file['tmp_name'],$this->storedFile);
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }
    
    /**
     * Rename the uploaded file.
     * @param string $new_name
     */
    public function rename($new_name){
        if($this->valid == TRUE){
            rename($this->storedFile,$this->storedDir.$new_name.".".$this->storedFileExt);
        } else {
            return FALSE;
        }
    }
    
    /**
     * Add a prefix to the file uploaded.
     * @param type $prefix
     * @return boolean
     */
    public function addPrefix($prefix){
        if($this->valid == TRUE){
            rename($this->storedFile,$this->storedDir.$prefix."_".$this->file['name'].".".$this->storedFileExt);
        } else {
            return FALSE;
        }
    }
}