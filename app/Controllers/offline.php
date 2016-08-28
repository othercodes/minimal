<?php

namespace Controllers;

class Offline extends \Minimal\Controller
{

    public function index()
    {
        // set message
        $data['title'] = "The site is offline";
        $data['message'] = "The site is under maintenance, come back later, thanks";
        // load data in the template
        $this->load->view('system/offline', $data);
    }
}