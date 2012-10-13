<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/../vendor/autoload.php';

//bootstrap and configuration
$app = new Silex\Application();
$app->register(new Silex\Provider\SecurityServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'host' => '127.0.0.1',
        'dbname' => 'movie_gateway',
        'user' => 'root',
        'password' => '',
    ),
));
$app->register(new Mrok\Provider\PasswordHasherServiceProvider());
$app->register(new Mrok\Provider\RabbitMQProvider(), array('rabbit.configuration' => Yaml::parse(__DIR__ . '/configuration/rabbit.yml')));

$app['validator.mapping.class_metadata_factory'] = new Symfony\Component\Validator\Mapping\ClassMetadataFactory(
    new Symfony\Component\Validator\Mapping\Loader\YamlFileLoader(__DIR__ . '/configuration/validation.yml')
);


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