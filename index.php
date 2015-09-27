<?php
define('DACCESS', 1);
require 'framework.php';

use System\Application;

$app = new Application();

$app->route();

$app->dispatch();

$app->render();
?>