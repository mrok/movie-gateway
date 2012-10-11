<?php

namespace Mrok;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

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

        $controllers->get('/add', function () {
            return 'media';
        });


        return $controllers;
    }
}