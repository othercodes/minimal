<?php

namespace Minimal;

/**
 * Class Application
 * @package Minimal
 */
class Application
{
    /**
     * Main app configuration
     * @var \OtherCode\FController\Components\Registry
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
     * Add a new GET task to the engine (WEB only)
     * @param string $path
     * @param string $controller
     * @param string|null $view
     * @return $this
     */
    public function get($path, $controller, $view = null)
    {
        $this->engine->tasks->set(null, new \Minimal\Task($path, $controller, 'GET', $view));
        return $this;
    }

    /**
     * Add a new POST task to the engine (WEB only)
     * @param string $path
     * @param string $controller
     * @param string|null $view
     * @return $this
     */
    public function post($path, $controller, $view = null)
    {
        $this->engine->tasks->set(null, new \Minimal\Task($path, $controller, 'POST', $view));
        return $this;
    }

    /**
     * Add a new PUT task to the engine (WEB only)
     * @param string $path
     * @param string $controller
     * @param string|null $view
     * @return $this
     */
    public function put($path, $controller, $view = null)
    {
        $this->engine->tasks->set(null, new \Minimal\Task($path, $controller, 'PUT', $view));
        return $this;
    }

    /**
     * Add a new PATCH task to the engine (WEB only)
     * @param string $path
     * @param string $controller
     * @param string|null $view
     * @return $this
     */
    public function patch($path, $controller, $view = null)
    {
        $this->engine->tasks->set(null, new \Minimal\Task($path, $controller, 'PATCH', $view));
        return $this;
    }

    /**
     * Add a new DELETE task to the engine (WEB only)
     * @param string $path
     * @param string $controller
     * @param string|null $view
     * @return $this
     */
    public function delete($path, $controller, $view = null)
    {
        $this->engine->tasks->set(null, new \Minimal\Task($path, $controller, 'DELETE', $view));
        return $this;
    }

    /**
     * Add a new OPTIONS task to the engine (WEB only)
     * @param string $path
     * @param string $controller
     * @param string|null $view
     * @return $this
     */
    public function options($path, $controller, $view = null)
    {
        $this->engine->tasks->set(null, new \Minimal\Task($path, $controller, 'OPTIONS', $view));
        return $this;
    }

    /**
     * Add a new HEAD task to the engine (WEB only)
     * @param string $path
     * @param string $controller
     * @param string|null $view
     * @return $this
     */
    public function head($path, $controller, $view = null)
    {
        $this->engine->tasks->set(null, new \Minimal\Task($path, $controller, 'HEAD', $view));
        return $this;
    }

    /**
     * Add a new TRACE task to the engine (WEB only)
     * @param string $path
     * @param string $controller
     * @param string|null $view
     * @return $this
     */
    public function trace($path, $controller, $view = null)
    {
        $this->engine->tasks->set(null, new \Minimal\Task($path, $controller, 'TRACE', $view));
        return $this;
    }

    /**
     * Add a new CONNECT task to the engine (WEB only)
     * @param string $path
     * @param string $controller
     * @param string|null $view
     * @return $this
     */
    public function connect($path, $controller, $view = null)
    {
        $this->engine->tasks->set(null, new \Minimal\Task($path, $controller, 'CONNECT', $view));
        return $this;
    }

    /**
     * Add a new CLI task to the engine (CLI only)
     * @param string $path
     * @param string $controller
     * @param string|null $view
     * @return $this
     */
    public function cli($path, $controller, $view = null)
    {
        $this->engine->tasks->set(null, new \Minimal\Task($path, $controller, 'CLI', $view));
        return $this;
    }

    /**
     * Execute the whole application
     * @throws \Minimal\Exceptions\ApplicationException
     */
    public function run()
    {
        try {

            $task = $this->engine->process();
            $this->kernel->setService('context', function () use ($task) {
                return $task;
            });

            $response = $this->kernel->run($task->controller, $task->parameters);

            if (isset($task->view)) {
                $this->render($task->view, $response);
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
