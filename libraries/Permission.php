<?php defined('DACCESS') or die ('Acceso restringido!');

/**
 * Gestiona los permisos de los archivos de un directorio.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @copyright (c) 2014, David Unay Santisteban
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3 
 */
class Permission {
    
    private $_tree = array();
    private $_state = array();
    private $_path;
    
    /**
     * Contrsuctor del objeto.
     * @param string $path
     */
    public function __construct($path = null) {
        $this->setPath($path);
    }
    
    /**
     * Establece la ruta.
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
     * Cambia los permisos de un archivo dado.
     * @param string $perms nuevos permisos, en octal. 
     * @param string $file ruta del archivo.
     * @return boolean
     */
    public function setPerms($perms,$file){
        return chmod($file,$perms);
    }
    
    /**
     * Cambia todos los permisos de los archivos o directorios de un directorio dado.
     * @param string $perms nuevos permisos.
     * @param boolean $recursive establece si el cambio es recursivo o no.
     * @param string $affected establece que elementos que seran afetados, ALL|FILE|DIR
     * @param string $path ruta del directorio.
     * @return boolean
     */
    public function setAllPerms($perms, $recursive = FALSE, $affected = 'ALL' ,$path = null){  
        if(!$path){
            $path = $this->_path;
        }
        if(!is_dir($path)){
            return FALSE;
        }
        if($affected != 'ALL' xor $affected != 'FILE' xor $affected != 'DIR'){
            return FALSE;
        }
        $root = opendir($path);
        while($entry = readdir($root)) {
            if ($entry != "." && $entry != "..") {
                if (is_dir($path.$entry)){
                    if($affected == 'ALL' xor $affected == 'DIR') {
                        $this->_state[] = $this->setPerms($perms,$path.$entry);
                    }
                    if ($recursive === TRUE){
                        $this->setAllPerms($perms, $recursive, $affected, $path.$entry.'/');
                    }
                } else {
                    if($affected == 'ALL' xor $affected == 'FILE') {
                        $this->_state[] = $this->setPerms($perms,$path.$entry);
                    }
                }
            } 
        }
        closedir($root);
        return $this->_state;
    }
    
    /**
     * Obtiene los permisos de un archivo.
     * @param string $file
     * @return array
     */
    public function getPerms($file){
        $permisos = fileperms($file);

        if (($permisos & 0xC000) == 0xC000) {
            // Socket
            $type = 's';
        } elseif (($permisos & 0xA000) == 0xA000) {
            // Enlace Simbólico
            $type = 'l';
        } elseif (($permisos & 0x8000) == 0x8000) {
            // Regular
            $type = '-';
        } elseif (($permisos & 0x6000) == 0x6000) {
            // Especial Bloque
            $type = 'b';
        } elseif (($permisos & 0x4000) == 0x4000) {
            // Directorio
            $type = 'd';
        } elseif (($permisos & 0x2000) == 0x2000) {
            // Especial Carácter
            $type = 'c';
        } elseif (($permisos & 0x1000) == 0x1000) {
            // Tubería FIFO
            $type = 'p';
        } else {
            // Desconocido
            $type = 'u';
        }

        $owner = (($permisos & 0x0100) ? 'r' : '-');
        $owner .= (($permisos & 0x0080) ? 'w' : '-');
        $owner .= (($permisos & 0x0040) ?
            (($permisos & 0x0800) ? 's' : 'x' ) :
            (($permisos & 0x0800) ? 'S' : '-'));

        $group = (($permisos & 0x0020) ? 'r' : '-');
        $group .= (($permisos & 0x0010) ? 'w' : '-');
        $group .= (($permisos & 0x0008) ?
            (($permisos & 0x0400) ? 's' : 'x' ) :
            (($permisos & 0x0400) ? 'S' : '-'));

        $other = (($permisos & 0x0004) ? 'r' : '-');
        $other .= (($permisos & 0x0002) ? 'w' : '-');
        $other .= (($permisos & 0x0001) ? 
            (($permisos & 0x0200) ? 't' : 'x' ) : 
            (($permisos & 0x0200) ? 'T' : '-'));
        
        return array(
            'name' => $file, 
            'type' => $type,
            'owner' => $owner,
            'group' => $group,
            'other' => $other,
        );
    }

    /**
     * Obtiene todos los permisos de los archivos de un directorio dado.
     * @param boolean $recursive 
     * @param string $path
     * @return array
     */
    public function getAllPerms($recursive = FALSE, $path = null){
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
                    $this->_tree[] = $this->getPerms($path.$entry);
                    if ($recursive === TRUE){
                        $this->getAllPerms($recursive, $path.$entry.'/');
                    }
                } else {
                    $this->_tree[] = $this->getPerms($path.$entry);
                }
            } 
        }
        closedir($root);
        return $this->_tree;
    }
    
}
?>