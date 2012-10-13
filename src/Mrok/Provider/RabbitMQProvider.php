<?php
namespace Mrok\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use PhpAmqpLib\Connection\AMQPConnection;

class RabbitMQProvider implements ServiceProviderInterface
{

    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app)
    {
        $queues = array();

        $app['rabbitMQ.queues'] = $app->protect(function ($qname) use ($app)
        {
            $queues = $app['rabbitMQ.queues.initialize']();

            if (!array_key_exists($qname, $queues)) {
                throw new \InvalidArgumentException('Requested queue does not exist');
            }

            return $queues[$qname];
        });

        $app['rabbitMQ.queues.initialize'] = $app->protect(function () use ($app, &$queues)
        {
            static $initialized = false;
            if ($initialized) {
                return $queues;
            }

            $config = $app['rabbit.configuration'];

            foreach ($config as $qconf) {
                $server = $qconf['server'];
                $qparams = $qconf['parameters'];

                $conn = new AMQPConnection($server['host'], $server['port'], $server['user'], $server['pass'], $server['vhost']);
                $channel = $conn->channel();
                $channel->queue_declare($qconf['name'], $qparams['passive'], $qparams['durable'], $qparams['exclusive'], $qparams['auto_delete']);

                $queues[$qconf['name']] = $channel;
            }
            $initialized = true;

            return $queues;
        });
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registers
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {

    }
}
