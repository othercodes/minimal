<?php

namespace Minimal;

/**
 * Class Application
 * @package Minimal
 */
class Application
{
    /**
     * @var
     */
    protected $configuration;

    /**
     * Application type WEB/CLI
     * @var string
     */
    protected $type;

    /**
     * Application Engine WEB/CLI
     * @var \Minimal\Engines\Engine
     */
    protected $engine;

    /**
     * Application Kernel.
     * @var \OtherCode\FController\FController
     */
    private $kernel;

    /**
     * Application constructor.
     * @param string $type
     * @throws Exceptions\ApplicationException
     */
    public function __construct($type = 'web')
    {
        if (!in_array($type, array('web', 'cli'))) {
            throw new \Minimal\Exceptions\ApplicationException('Invalid application type.');
        }

        session_start();

        $this->type = strtolower($type);
        $this->kernel = \OtherCode\FController\FController::getInstance();

        $this->configuration = new \OtherCode\FController\Components\Registry();

        $engine = '\Minimal\Engines\\' . strtoupper($this->type);
        $this->engine = new $engine($this->configuration);
    }

    public function configure()
    {

    }

    /**
     * Add a new call to the engine (WEB only)
     * @param string $path
     * @param string $controller
     * @param string $method
     * @param string|null $view
     * @return $this
     */
    public function add($path, $controller, $method = 'GET', $view = null)
    {
        $this->engine->calls->set(null, new \Minimal\Call($path, $controller, $method, $view));
        return $this;
    }

    /**
     * Add a new GET call to the engine (WEB only)
     * @param string $path
     * @param string $controller
     * @param string|null $view
     * @return $this
     */
    public function get($path, $controller, $view = null)
    {
        $this->engine->calls->set(null, new \Minimal\Call($path, $controller, 'GET', $view));
        return $this;
    }

    /**
     * Add a new POST call to the engine (WEB only)
     * @param string $path
     * @param string $controller
     * @param string|null $view
     * @return $this
     */
    public function post($path, $controller, $view = null)
    {
        $this->engine->calls->set(null, new \Minimal\Call($path, $controller, 'POST', $view));
        return $this;
    }

    /**
     * Add a new PUT call to the engine (WEB only)
     * @param string $path
     * @param string $controller
     * @param string|null $view
     * @return $this
     */
    public function put($path, $controller, $view = null)
    {
        $this->engine->calls->set(null, new \Minimal\Call($path, $controller, 'PUT', $view));
        return $this;
    }

    /**
     * Add a new PATCH call to the engine (WEB only)
     * @param string $path
     * @param string $controller
     * @param string|null $view
     * @return $this
     */
    public function patch($path, $controller, $view = null)
    {
        $this->engine->calls->set(null, new \Minimal\Call($path, $controller, 'PATCH', $view));
        return $this;
    }

    /**
     * Add a new DELETE call to the engine (WEB only)
     * @param string $path
     * @param string $controller
     * @param string|null $view
     * @return $this
     */
    public function delete($path, $controller, $view = null)
    {
        $this->engine->calls->set(null, new \Minimal\Call($path, $controller, 'DELETE', $view));
        return $this;
    }

    /**
     * Add a new OPTIONS call to the engine (WEB only)
     * @param string $path
     * @param string $controller
     * @param string|null $view
     * @return $this
     */
    public function options($path, $controller, $view = null)
    {
        $this->engine->calls->set(null, new \Minimal\Call($path, $controller, 'OPTIONS', $view));
        return $this;
    }

    /**
     * Add a new HEAD call to the engine (WEB only)
     * @param string $path
     * @param string $controller
     * @param string|null $view
     * @return $this
     */
    public function head($path, $controller, $view = null)
    {
        $this->engine->calls->set(null, new \Minimal\Call($path, $controller, 'HEAD', $view));
        return $this;
    }

    /**
     * Add a new TRACE call to the engine (WEB only)
     * @param string $path
     * @param string $controller
     * @param string|null $view
     * @return $this
     */
    public function trace($path, $controller, $view = null)
    {
        $this->engine->calls->set(null, new \Minimal\Call($path, $controller, 'TRACE', $view));
        return $this;
    }

    /**
     * Add a new CONNECT call to the engine (WEB only)
     * @param string $path
     * @param string $controller
     * @param string|null $view
     * @return $this
     */
    public function connect($path, $controller, $view = null)
    {
        $this->engine->calls->set(null, new \Minimal\Call($path, $controller, 'CONNECT', $view));
        return $this;
    }

    /**
     * Add a new CLI call to the engine (CLI only)
     * @param string $path
     * @param string $controller
     * @param string|null $view
     * @return $this
     */
    public function cli($path, $controller, $view = null)
    {
        $this->engine->calls->set(null, new \Minimal\Call($path, $controller, 'CLI', $view));
        return $this;
    }

    /**
     * Execute the whole application
     * @throws \Minimal\Exceptions\ApplicationException
     */
    public function run()
    {
        try {

            $call = $this->engine->process();
            $this->kernel->setService('context', function () use ($call) {
                return $call;
            });

            $response = $this->kernel->run($call->controller, $call->parameters);

            var_dump($response);

            // process the views.


        } catch (\Exception $e) {

            // log the error and transform the exception
            throw new \Minimal\Exceptions\ApplicationException($e->getMessage(), $e->getCode());

        }
    }
}
