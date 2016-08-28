<?php

namespace Minimal;


class Application
{
    /**
     * Application type WEB/CLI
     * @var string
     */
    protected $type;

    /**
     * Application Engine WEB/CLI
     * @var
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

        $engine = '\Minimal\Engines\\' . strtoupper($this->type);
        $this->engine = new $engine();
    }

    public function addRoute()
    {

    }

    public function run()
    {

    }
}
