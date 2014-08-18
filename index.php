<?php
define('DACCESS',1);
require 'framework.php';

$app = new Application();

$app->route();

$app->dispatch();

$app->render();
?>