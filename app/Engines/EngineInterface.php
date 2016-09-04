<?php

namespace Minimal\Engines;

/**
 * Class EngineInterface
 * @package Minimal\Engines
 */
interface EngineInterface
{
    /**
     * Process the routes based on the WEB engine logic.
     * @return \Minimal\Task
     */
    public function process();

}