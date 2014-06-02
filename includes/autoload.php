<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * Lista de clases y librerias de funciones que se quieren 
 * cargar al iniciar la aplicacion, estas librerias siempre 
 * estaran disponibles si se incluyen aqui.
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