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
     * @return \Minimal\Call
     */
    public function process()
    {
        foreach ($this->calls as $call) {
            $preparedUri = strtr($call->pattern, $this->patters);
            if (preg_match('/^' . $preparedUri . '$/', $this->uri) === 1 && $this->method === $call->method) {

                $uriSegments = array_filter(explode('/', trim($this->uri, '/')));
                $callSegments = array_filter(explode('/', trim($call->pattern, '/')));

                $call->parameters = array_diff($uriSegments, $callSegments);

                return $call;
            }
        }

        return new \Minimal\Call('/', 'help.base', 'CLI', 'help.raw');
    }
}