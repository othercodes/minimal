<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Benchmark system.
 * @author David Unay Santisteban <slavepens@gamil.com>
 * @package SlaveFramework
 * @subpackage System
 * @version 1.0
 */
class Benchmark {
    
    private $marker = array();
    
    /**
     * Contructor class
     */
    public function __construct() {
        $this->marker['init'] = microtime(true);
    }
    
    /**
     * Creates a marker point in the time line.
     * @param type $name
     */
    public function mark($name) {
		$this->marker[$name] = microtime(true);
	}
    
    /**
     * Generate a report with the diference between markers
     */
    public function report(){
        echo "<table>";
        foreach($this->marker as $mark => $value){
            $diference = $value - $this->marker['init'];
            echo "<tr><td>".$mark."</td><td>".$diference."</td></tr>";
        }
        echo "</table>";
    }
    
}