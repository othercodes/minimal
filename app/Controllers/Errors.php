<?php

namespace Minimal\Controllers;

class Errors extends \Minimal\Controller
{
    public function notfound()
    {
        return (object)array(
            'title' => 'Error 404',
            'message' => 'Whoops! 404 page not found'
        );
    }
}