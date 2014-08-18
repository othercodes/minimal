<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * List of classes that are loaded when you start the application, 
 * these libraries always be available if they are included here.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */

$classes = array(
    'Security'      => 'libraries',
    'Session'       => 'libraries',
    'Database'      => 'libraries',
    'Language'      => 'libraries',
    'Permission'    => 'libraries',
    'Integrity'     => 'libraries',
    'Input'         => 'libraries',
    'Upload'        => 'libraries',
    'Url'           => 'libraries'
);