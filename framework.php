<?php

defined('DACCESS') or die ('Acceso restringido!');

/**
 * Autoload systems
 */
require_once 'vendor/autoload.php';
require_once 'app/autoload.php';

/**
 * Definition of system paths.
 */
define('ROOT_PATH', dirname(__FILE__));
define('APP_PATH', ROOT_PATH . '/app');

/**
 * Custom error handler, transform any error into exception
 */
set_error_handler(function ($level, $message, $file, $line) {
    if (!(error_reporting() & $level)) {
        return null;
    }
    throw new \Exception($message . ' at ' . $file . ':' . $line, 500);
});

/**
 * Load the actual framework
 */
$loader = new Autoload();
$loader->addNamespace('Minimal', APP_PATH);
$loader->register();