<?php

namespace Minimal;

/**
 * Class Task
 * @package Minimal
 */
class Task
{
    /**
     * Allowed method GET|POST|PUT|PATCH|HEAD|OPTIONS|CONNECT|CLI
     * In CLI Engine this parameter will be ignored.
     * @var string
     */
    public $method;

    /**
     * Task pattern
     * @var string
     */
    public $pattern;

    /**
     * Controller and method to launch.
     * @var string
     */
    public $controller;

    /**
     * Task parameters
     * @var array
     */
    public $parameters = array();

    /**
     * View type
     * @var null|string
     */
    public $view;

    /**
     * Route constructor.
     * @param string $pattern
     * @param string $controller
     * @param string $method
     * @param string $view
     */
    public function __construct($pattern, $controller, $method = 'GET', $view = null)
    {
        $this->pattern = ($pattern === '/') ? $pattern : trim($pattern, '/');
        $this->controller = $controller;
        $this->method = strtoupper($method);
        $this->view = $view;
    }
}