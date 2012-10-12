<?php

namespace Mrok;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Mrok\Repository\MovieRepository;
use Mrok\Entity\Movie;

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

            $sql = "SELECT * FROM customer WHERE username = ? AND password = ?";
            $user = $app['db']->fetchAssoc($sql, array($username, $passhash));
            if ($user) {
                $movieRepository = new MovieRepository();
                $movie = $movieRepository->createFromRequest($request);
                $errors = $app['validator']->validate($movie);
                if (count($errors) > 0) {
                    return new Response('Bad request', 400);
                }


            }

            return new Response('Unauthorized', 401);
        });


        return $controllers;
    }
}