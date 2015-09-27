<?php namespace Configuration\Database;

use System\BaseConfig;

/**
 * Class configuration for the database.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */
class DefaultDB extends BaseConfig
{
    public $driver = 'mysql';
    public $dbhost = 'localhost';
    public $dbuser = 'root';
    public $dbpass = 'root';
    public $dbname = 'test';
    public $prefix = 'pfx_';
}