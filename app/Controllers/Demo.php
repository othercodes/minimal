<?php

namespace Minimal\Controllers;

class Demo extends \Minimal\Controller
{

    public function index()
    {
        $data['demo'] = 'Demo';
        $this->load->view('demo', $data);
    }
}