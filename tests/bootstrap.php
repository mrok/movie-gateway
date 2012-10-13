<?php

$app = require __DIR__ . '/../app/app.php';
$app['debug'] = true;

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

return $app;