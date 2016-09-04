<?php

namespace Minimal\Engines;

/**
 * Web Class
 * @author usantisteban
 * @version 1.0
 * @package app\Engines
 */
class WEB extends \Minimal\Engines\Engine
{
    /**
     * The current requested method
     * @var string
     */
    private $method;

    /**
     * The current requested URI
     * @var string
     */
    private $uri;

    /**
     * The base url of the app
     * @var string
     */
    private $baseurl;

    /**
     * Available wildcards patters
     * @var array
     */
    private $patters = array(
        '{:str}' => '[a-zA-Z]+',
        '{:int}' => '[0-9]+',
        '{:var}' => '[a-zA-Z0-9]+',
        '/' => '\/',
    );

    /**
     * WEB constructor.
     * @param \OtherCode\FController\Components\Registry $configuration
     */
    public function __construct(\OtherCode\FController\Components\Registry $configuration)
    {
        parent::__construct($configuration);
        $len = strlen($_SERVER['REQUEST_URI']) - (strlen($_SERVER['SCRIPT_NAME']) - 9);
        $this->uri = ($len === 0) ? '/' : trim(substr($_SERVER['REQUEST_URI'], -$len), '/');
        $this->baseurl = substr($_SERVER['SCRIPT_NAME'], 0, -10);
        $this->method = strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Process the routes based on the WEB engine logic.
     * @return \Minimal\Task
     */
    public function process()
    {
        foreach ($this->tasks as $task) {
            $preparedUri = strtr($task->pattern, $this->patters);
            if (preg_match('/^' . $preparedUri . '$/', $this->uri) === 1 && $this->method === $task->method) {

                $uriSegments = array_filter(explode('/', trim($this->uri, '/')));
                $taskSegments = array_filter(explode('/', trim($task->pattern, '/')));

                $task->parameters = array_diff($uriSegments, $taskSegments);

                return $task;
            }
        }
        return new \Minimal\Task('/', 'errors.notfound', 'GET', 'notfound.html');
    }
}