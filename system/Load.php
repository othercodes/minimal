<?php namespace System;

use Libraries\Database;

/**
 * Is responsible for loading the libraries, models and views, on demand request
 * controller defined by user.
 * @author David Unay Santisteban <slavepens@gamil.com>
 * @package SlaveFramework
 * @subpackage System
 * @version 1.0
 */
class Load
{

    /**
     * Import the chosen data model.
     * @params string $model
     */
    public function model($model)
    {
        if (!include MODLS_PATH . $model . ".php") {
            echo "Error loading " . $model . " model";
        }
        $instance =& Controller::getInstance();
        $instance->$model = new $model();
    }

    /**
     * Loads the selected view and import data.
     * @param string $view
     * @param array $data
     * @return mixed
     */
    public function view($view, $data = array())
    {
        $this->nexus(array('views' => $view, 'vars' => $data));
    }

    /**
     * Loads a new instance of the database class with a new connect config.
     * @param string $setup the name of the class in the inlcudes/DefaultDB.php file
     * @return Database
     */
    public function database($setup)
    {
        return new Database($setup);
    }

    /**
     * Allow to the app to join data with the views
     * @param array $traverse
     */
    public function nexus($traverse)
    {
        $instance =& Controller::getInstance();
        foreach (get_object_vars($instance) as $_sl_key => $_sl_var) {
            if (!isset($this->buffer)) {
                $this->$_sl_key =& $instance->$_sl_key;
            }
        }
        ob_start();
        if (isset($traverse['vars'])) {
            foreach ($traverse['vars'] as $key => $value) {
                $$key = $value;
            }
        }
        if (!include VIEWS_PATH . $traverse['views'] . ".php") {
            echo "Error loading " . $traverse['views'] . " view";
        }

        $instance->buffer .= ob_get_clean();

        if (Application::loadConfig('compress') == 1) {
            $search = array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s');
            $replace = array('>', '<', '\\1');
            $instance->buffer = preg_replace($search, $replace, $instance->buffer);
        }
    }


}
