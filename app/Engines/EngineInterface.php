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
     * @return \Minimal\Call
     */
    public function process();

}