<?php

namespace Minimal\Engines;

/**
 * CLI Class
 * @author usantisteban
 * @version 1.0
 * @package app\Engines
 */
class CLI extends \Minimal\Engines\Engine
{
    /**
     * @var array
     */
    private $arguments;

    /**
     * WEB constructor.
     * @param \OtherCode\FController\Components\Registry $configuration
     */
    public function __construct(\OtherCode\FController\Components\Registry $configuration)
    {
        parent::__construct($configuration);
        $this->arguments = $_SERVER['argv'];

        var_dump($this);
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

        return new \Minimal\Task('/', 'help.base', 'CLI', 'help.raw');
    }
}