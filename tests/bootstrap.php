<?php

$app = require __DIR__ . '/../app/app.php';
$app['debug'] = true;
//TODO create separate db for tests

return $app;