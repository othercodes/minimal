<?php namespace Libraries;

/**
 * Input control class.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @subpackage Libraries
 * @version 1.2
 */

class Input
{
    /**
     * POST variables
     * @var array
     */
    private $post = array();

    /**
     * GET variables
     * @var array
     */
    private $get = array();

    /**
     * Dump and sanitize all the POST and GET data
     * in privates variables.
     */
    public function __construct()
    {
        foreach ($_POST as $key => $value) {
            $this->post[$key] = htmlspecialchars($value, ENT_QUOTES);
        }
        unset($_POST);
        foreach ($_GET as $key => $value) {
            $this->get[$key] = htmlspecialchars($value, ENT_QUOTES);
        }
        unset($_GET);
    }

    /**
     * Get data from POST method
     * @param string $index
     * @return mixed
     */
    public function post($index = null)
    {
        if (isset($index)) {
            if (isset($this->post[$index])) {
                return $this->post[$index];
            }
            return null;
        }
        return $this->post;
    }

    /**
     * Get data from GET method
     * @param string $index
     * @return mixed
     */
    public function get($index = null)
    {
        if (isset($index)) {
            if (isset($this->get[$index])) {
                return $this->get[$index];
            }
            return null;
        }
        return $this->get;
    }

    /**
     * Get the json data from the raw input stream.
     * @return mixed
     */
    public function getJsonRequest()
    {
        return json_decode(file_get_contents('php://input'), true);
    }
}