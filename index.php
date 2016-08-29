<?php

define('DACCESS', 1);

require 'framework.php';

$app = new \Minimal\Application('web');

$app->setControllers(array(
    'demo' => 'Minimal\Controllers\Demo'
));

$app->get('/sayhello/to/{:str}/{:int}', 'demo.index');

$app->run();