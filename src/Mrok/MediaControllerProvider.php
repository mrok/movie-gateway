<?php

namespace Mrok;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;

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

        $controllers->get('/add', function (Request $request) use ($app)
        {
            $username = $request->get('username');
            $password = $request->get('password');
            $passhash = $app['password-hasher']($username, $password);

            $sql = "SELECT * FROM customer WHERE username = ? AND password = ?";
            $post = $app['db']->fetchAssoc($sql, array($username, $passhash));
//            var_dump($post);

            return 'media';
        });


        return $controllers;
    }
}