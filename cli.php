<?php

define('DACCESS', 1);

require 'framework.php';

$app = new \Minimal\Application('cli');
$app->get('sayhi', 'dummy.test');
$app->run();