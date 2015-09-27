<?php namespace Configuration\Database;

use System\BaseConfig;

/**
 * Custom connection class, you can create as many as you want
 * each one for a different database connection.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */
class Custom extends BaseConfig
{
    public $driver = 'mysql';
    public $dbhost = 'localhost';
    public $dbuser = 'root';
    public $dbpass = 'root';
    public $dbname = 'test';
    public $prefix = 'pfx_';
}