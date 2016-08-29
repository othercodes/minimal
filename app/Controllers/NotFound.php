<?php

namespace Minimal\Controllers;

class NotFound extends \Minimal\Controller
{
    public function index()
    {
        // set the message
        $data['title'] = "Page not Found";
        $data['message'] = "The requested page is not available.";
        // load data into the template
        $this->load->view('errors/404', $data);
    }

}