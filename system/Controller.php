<?php namespace System;

/**
 * Main application controller, this inherited all other drivers.
 * @author David Unay Santisteban <slavepens@gamil.com>
 * @package SlaveFramework
 * @subpackage System
 * @version 1.0
 */
class Controller
{
    /**
     * @var Controller
     */
    private static $instance;

    /**
     * Controller buffer
     * @var string
     */
    public $buffer;

    /**
     * Constructor of the main Controller.
     */
    public function __construct()
    {
        $classes = array();

        self::$instance =& $this;
        // init the dinamic loader
        $this->load = new Load();
        // init the system logger 
        $this->logger = new Logger();
        // import the autoload list
        if (!@include INCLUDE_PATH . "autoload.php") {
            echo "Error loading autoload.php";
        }
        // load the default classes
        if (count($classes) > 0) {
            foreach ($classes as $index => $class) {
                $object = strtolower($index);
                $this->$object = new $class();
            }
        }
    }

    /**
     * Return the controller instance.
     * @return object
     */
    public static function &getInstance()
    {
        return self::$instance;
    }

}
