<?php

require_once './autoload.php';

use app\Main;

$fileName = $argv[1];
$path = __DIR__ . '/' . $fileName;

$app = new Main();
$app->run($path);