<?php defined('DACCESS') or die ('Acceso restringido!');

/**
 * Clase que permite gestionar las subidas de archivos al servidor.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @copyright (c) 2014, David Unay Santisteban
 * @version 1.0.20140301
 */
class Upload {
    
    private $file = array();
    private $valid = TRUE;
    private $storedDir;
    private $storedFile;
    private $storedFileExt;
    
    /**
     * Crea el objeto de subida.
     */
    public function __construct() {}
    
    /**
     * Inicia la subida.
     * @param type $uploadedFile
     */
    public function uploadFile($uploadedFile){
        if($uploadedFile['error'] == 0){
            $this->file = $uploadedFile;
        } else {
            echo $uploadedFile['error'];
        }
    }

    /**
     * Valida la extension, el tipo y el tamaño del archivo
     * @param array $allowedSize tamaño maximo en MB.
     * @param array $allowedExt lista de extensiones.
     * @param array $allowedTypes lista de tipos MIME validos.
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
     * Guarda el archivo en el directorio dado.
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
     * Renombra el archivo subido.
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
     * Añade un prefijo al archivo subido.
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