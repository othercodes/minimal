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

        $this->kernel = \OtherCode\FController\FController::getInstance();
        $this->configuration = new \OtherCode\FController\Components\Registry();

        $engine = '\Minimal\Engines\\' . strtoupper($type);
        $this->engine = new $engine($this->configuration);

        $this->setControllers(array(
            'errors' => 'Minimal\Controllers\Errors',
            'help' => 'Minimal\Controllers\Help'
        ));
    }

    /**
     * Load a list of controllers
     * @param array $controllers
     * @return $this
     */
    public function setControllers(array $controllers)
    {
        foreach ($controllers as $name => $controller) {
            $this->setController($name, $controller);
        }
        return $this;
    }

    /**
     * Load a single controller
     * @param string $name
     * @param string $controller
     * @return $this
     */
    public function setController($name, $controller)
    {
        $this->kernel->setModule($name, $controller);
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

            if (isset($call->view)) {
                $this->render($call->view, $response);
            }

        } catch (\Exception $e) {

            // log the error and transform the exception
            throw new \Minimal\Exceptions\ApplicationException($e->getMessage(), $e->getCode());

        }
    }

    /**
     * Render a view
     * @param string $view
     * @param object $model
     */
    public function render($view, $model)
    {
        $twig = new \Twig_Environment(new \Twig_Loader_Filesystem(APP_PATH . '/Views'));
        print $twig->render($view . '.twig', array('model' => $model));
    }
}
