<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Benchmark system.
 * @author David Unay Santisteban <slavepens@gamil.com>
 * @package SlaveFramework
 * @version 1.0
 */
class Benchmark {
    
    private $marker = array();
    
    /**
     * 
     */
    public function __construct() {
        $this->marker['init'] = microtime(true);
    }
    
    /**
     * 
     * @param type $name
     */
    public function mark($name) {
		$this->marker[$name] = microtime(true);
	}
    
    /**
     * 
     */
    public function report(){
        for($i=0;$i<count($this->marker);$i++){
            echo $this->marker[$i];
        }
    }
    
}