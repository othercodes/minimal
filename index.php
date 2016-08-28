<?php

define('DACCESS', 1);

require 'framework.php';

$app = new \Minimal\Application('web');

$app->run();

var_dump($app);