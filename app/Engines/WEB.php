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

        return new \Minimal\Call('/', 'default.index', 'GET', 'html');
    }
}