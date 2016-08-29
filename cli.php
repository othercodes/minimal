<?php

define('DACCESS', 1);

require 'framework.php';

$app = new \Minimal\Application('cli');

$app->setControllers(array(
    'demo' => 'Minimal\Controllers\Demo'
));

$app->cli('sayhi', 'demo.test');

$app->run();