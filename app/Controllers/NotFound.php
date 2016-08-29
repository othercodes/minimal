<?php

namespace Minimal\Controllers;

class NotFound extends \Minimal\Controller
{
    public function index()
    {
        $this->context->view = 'errors/404.html';

        return (object)array(
            'title' => 'Error 404',
            'message' => 'Whoops! 404 page not found'
        );
    }
}