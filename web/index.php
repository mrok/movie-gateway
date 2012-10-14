<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 0);

$app = require __DIR__.'/../app/app.php';
$app->run();