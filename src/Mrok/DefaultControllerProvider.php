<?php

namespace Mrok;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

class DefaultControllerProvider implements ControllerProviderInterface
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

        $controllers->get('/', function (Request $request) use($app)
        {
            $url = $request->getBaseUrl() . '/stats';
            return $app->redirect($url);
        });

        return $controllers;
    }
}