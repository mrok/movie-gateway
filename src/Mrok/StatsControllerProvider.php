<?php
namespace Mrok;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

class StatsControllerProvider implements ControllerProviderInterface
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

        $controllers->get('/', function () use ($app)
        {
            $customers = $app['repository']['Customer']->getAll(); //there is no more than 300customers, no sense to paginate now
            return $app['twig']->render('stats/list.twig', array(
                'customers' => $customers,
            ));
        });

        return $controllers;
    }
}
