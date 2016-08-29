<?php

namespace Minimal\Controllers;

class Demo extends \Minimal\Controller
{
    public function index($user, $id)
    {
        $this->context->view = 'default.html';

        return (object)array(
            'id' => $id,
            'user' => $user
        );
    }
}