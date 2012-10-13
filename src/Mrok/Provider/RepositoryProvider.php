<?php
namespace Mrok\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class RepositoryProvider implements ServiceProviderInterface
{

    /**
     * Registers services on the given app.
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app)
    {

    }

    /**
     * Bootstraps the application.
     *
     * Find all possible repository and initialize them, after that repository should be available under $app['repository']['repoName']
     * This way let us mock repository easily
     * //TODO add some cache
     */
    public function boot(Application $app)
    {
        $repositories = array();

        $directory = dirname(__FILE__) . "/../Repository";
        $iterator = new \DirectoryIterator($directory);
        foreach ($iterator as $fileinfo) {
            if ($fileinfo->isFile()) {
                $filename = $fileinfo->getBasename('.php');
                if (substr($filename, -10) === 'Repository') {
                    $repoName = substr($filename, 0, -10);
                    $classPath = '\Mrok\Repository\\' . $filename;
                    $repo = new $classPath;

                    $repo->setDAO($app['db']);
                    $repositories[$repoName] = $repo;
                }
            }
        }
        $app['repository'] = $repositories;
    }
}