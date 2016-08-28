<?php

define('DACCESS', 1);

require 'framework.php';

$app = new \Minimal\Application('cli');

$app->run();

var_dump($app);