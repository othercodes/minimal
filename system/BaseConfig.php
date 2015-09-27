<?php namespace System;

/**
 * Base Config class
 * @author David Unay Santisteban <slavepens@gamil.com>
 * @package SlaveFramework
 * @subpackage System
 * @version 1.0
 */

abstract class BaseConfig
{


    public function __construct()
    {
    }

    /**
     * Get the value of the selected key;
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->$key;
    }
}