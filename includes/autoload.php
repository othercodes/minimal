<?php defined('DACCESS') or die ('Acceso restringido!');
/**
 * List of classes that are loaded when you start the application,
 * these libraries always be available if they are included here.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @version 1.0
 */

$classes = array(
    'Security' => 'Libraries\Security',
    'Session' => 'Libraries\Session',
    'Database' => 'Libraries\Database',
    'Language' => 'Libraries\Language',
    'Permission' => 'Libraries\Permission',
    'Pagination' => 'Libraries\Pagination',
    'Integrity' => 'Libraries\Integrity',
    'Input' => 'Libraries\Input',
    'Upload' => 'Libraries\Upload',
    'Url' => 'Libraries\Url'
);