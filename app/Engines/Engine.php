<?php

namespace Minimal\Engines;


/**
 * Class Engine
 * @package Minimal\Engines
 */
abstract class Engine implements \Minimal\Engines\EngineInterface
{

    /**
     * Routes collection.
     * @var \OtherCode\FController\Components\Registry
     */
    public $tasks;

    /**
     * Main configuration
     * @var \OtherCode\FController\Components\Registry
     */
    protected $configuration;

    /**
     * Engine constructor.
     * @param \OtherCode\FController\Components\Registry $configuration
     */
    public function __construct(\OtherCode\FController\Components\Registry $configuration)
    {
        $this->configuration = $configuration;
        $this->tasks = new \OtherCode\FController\Components\Registry();
    }
}