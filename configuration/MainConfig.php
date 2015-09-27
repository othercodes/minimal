<?php namespace Configuration;

use System\BaseConfig;

/**
 * Class System Setup, here you can add custom configs and
 * access later using Application::loadConfig('property'),
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */
class MainConfig extends BaseConfig
{
    public $offline = 0;
    public $encoding = 'UTF-8';
    public $language = 'en_US';
    public $log_path = 'logs';
    public $cache = 0;
    public $cache_path = 'cache';
    public $cache_time = '3600';
    public $debug = 0;
    public $compress = 1;
}

;
