<?php

namespace Mrok\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;


class PasswordHasherServiceProvider implements ServiceProviderInterface
{

    /**
     * Registers services on the given app.
     *
     * Provide common password hash functionality
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app)
    {
        $app['password-hasher'] = $app->protect(function ($username, $password) {
            $phrase = $username .$password;

            return hash('haval192,5', $phrase);
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
