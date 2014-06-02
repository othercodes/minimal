<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Clase de configuracion para la base de datos.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */
class Dbconfig {
    public $driver = 'mysql';
    public $dbhost = 'localhost';
    public $dbuser = 'root';
    public $dbpass = 'root';
    public $dbname = 'test';
    public $prefix = 'pfx_';
}