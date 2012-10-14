<?php

namespace Mrok;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Mrok\Repository\MovieRepository;
use Mrok\Entity\Movie;
use PhpAmqpLib\Message\AMQPMessage;

class MediaControllerProvider implements ControllerProviderInterface
{

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->post('/add', function (Request $request) use ($app)
        {
            $username = $request->get('customer_username');
            $password = $request->get('customer_password');
            $passhash = $app['password-hasher']($username, $password);

            $user = $app['repository']['Customer']->getLoggedUser($username, $passhash);
            if ($user) {
                $movie = $app['repository']['Movie']->createFromRequest($request);
                $movie->customerId = $user['id'];
                $errors = $app['validator']->validate($movie);
                if (count($errors) > 0) {
                    return new Response('Bad request', 400);
                } else {
                    $message = new AMQPMessage(json_encode($movie));
                    $queue = $app['rabbitMQ.queues']('movie-gateway');
                    $queue->publish($message);

                    $app['repository']['Customer']->increaseCustomerMovieCounter($user['id']);
                    $app['repository']['Movie']->persist($movie);

                    return new Response('OK', 200);
                }
            }

            return new Response('Unauthorized', 401);
        });

        return $controllers;
    }
}