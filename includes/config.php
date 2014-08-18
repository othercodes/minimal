<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Class System Setup, here you can add custom configs and
 * access later using Application::loadConfig('property');
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */
class Config {

    public $offline = 0;
    public $encoding = 'UTF-8';
    public $language = 'en_US';
    public $log_path = 'logs';
    public $cache = 1;
    public $cache_path = 'cache';
    public $cachetime = '3600';
}
