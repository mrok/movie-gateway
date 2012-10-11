<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__.'/../vendor/autoload.php';

//bootstrap and configuration
$app = new Silex\Application();
$app->register(new Silex\Provider\SecurityServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());

$app['security.firewalls'] = array(
    'http-auth' => array(
        'pattern' => '^/stats',
        'http' => true,
        'users' => array(
            'test' => array('ROLE_ADMIN', 'stHGdg4MhYOm/OVTWjpMJievIvJqafsQQ3WpWlUNDT6WfHupVWjBQaxdppMQkdCmYSXl6QQQXVYLGL/MDZi5Zw=='),
        ),
    ),
);

// define controllers for media module
$app->mount('/', new Mrok\DefaultControllerProvider());
$app->mount('/stats', new Mrok\StatsControllerProvider());
$app->mount('/media', new Mrok\MediaControllerProvider());

return $app;