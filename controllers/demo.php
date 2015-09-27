<?php namespace Controllers;

use System\Controller;

/**
 * Default "demo" controller..
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @subpackage Controller
 * @version 1.0
 */
class Demo extends Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['demo'] = 'Demo';
        $this->load->view('demo', $data);
    }
}