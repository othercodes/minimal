<?php

define('DACCESS', 1);

require 'framework.php';

$app = new \Minimal\Application('web');

$app->get('/sayhello/to/{:str}/{:int}', 'say.hello');
$app->get('/saygoodbye/{:str}', 'say.goodbye');

$app->run();