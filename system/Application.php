<?php namespace System;

/**
 * Bootstrap Class
 * @author David Unay Santisteban <slavepens@gamil.com>
 * @package SlaveFramework
 * @subpackage System
 * @version 1.0
 */
class Application
{

    public static $_config = array();

    private $_router;
    private $_cache;
    private $_controller;
    private $_datagram = array();
    private $_benchmark;


    /**
     * App constructor.
     */
    public function __construct()
    {
        session_start();
        mb_internal_encoding(self::loadConfig('encoding'));
        $this->_benchmark = new Benchmark();
        $this->_router = new Router();
        $this->_cache = new Cache();
        $this->_benchmark->mark("init_complete");
    }

    /**
     * Route the app to get the controller, method and arguments
     * to execute.
     */
    public function route()
    {
        $this->_router->configure();
        $this->_router->match();
        $this->_router->segment();
        $this->_datagram = $this->_router->dispatch();
        $this->_benchmark->mark("route_complete");
    }

    /**
     * Loads the specified controller and methods
     * with arguments by the router.
     */
    public function dispatch()
    {

        if (!include_once CTRLS_PATH . $this->_datagram['controller'] . '.php') {
            die ("Error loading " . $this->_datagram['controller'] . " controller");
        }

        $class = "Controllers\\".ucfirst($this->_datagram['controller']);
        $this->_controller = new $class();

        if (isset($this->_datagram['method'])) {
            $method = $this->_datagram['method'];
        } else {
            //default method
            $method = 'index';
        }

        if (method_exists($class, $method)) {
            if (isset($this->_datagram['args'])) {
                $args = $this->_datagram['args'];
            } else {
                $args = array(null);
            }

            // is cache system enabled?
            if ($this->_cache->enable == 1) {
                // check cache file life time
                $this->_cache->check($this->_router->getPath());
                if (!$this->_cache->showcache) {
                    // ejecutamos el metodo con sus argumentos, si es que existen.
                    call_user_func_array(array($this->_controller, $method), $args);
                }
            } else {
                // ejecutamos el metodo con sus argumentos, si es que existen.
                call_user_func_array(array($this->_controller, $method), $args);
            }
        }
        $this->_benchmark->mark("dispatch_complete");
    }

    /**
     * Render the app.
     */
    public function render()
    {
        if ($this->_cache->enable == 1) {
            print $this->_cache->dump();
        } else {
            print $this->_controller->buffer;
        }
        $this->_benchmark->mark("render_complete");
        if (self::loadConfig('debug') == 1) {
            $this->_benchmark->report();
        }
    }

    /**
     * Return the requested config value.
     * @param string $key config key.
     * @param string $source config class.
     * @return mixed
     */
    public static function loadConfig($key, $source = "MainConfig")
    {
        $class = "Configuration\\" . $source;

        if (!array_key_exists($source, self::$_config)) {
            self::$_config[$source] = new $class();
        }

        return self::$_config[$source]->$key;
    }
}
