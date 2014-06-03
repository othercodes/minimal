<?php defined('DACCESS') or die ('Acceso restringido!');

/* Establish error levels */
error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE);

/* Import the definition file paths. */
if(!@require 'includes/defines.php'){
    echo "Error loading defines.php";
}

/* Load the main system libraries. */
spl_autoload_register(function ($class) {
    if(!@require SYSTEM_PATH. $class . '.php'){
        echo "Error loading ".$class." class";
    }
});
