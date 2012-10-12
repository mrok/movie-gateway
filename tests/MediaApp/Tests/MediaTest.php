<?php

namespace MediaApp\Tests;

use Silex\WebTestCase;

class MediaTest extends WebTestCase
{

    public function createApplication()
    {
        $app = require __DIR__ . '/../../../app/app.php';
        $app['debug'] = true;

        return $app;
    }

    /**
     * @test
     */
    public function wrongCredentials()
    {
        $client = $this->createClient();
        $client->request('POST', '/media/add');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

}
