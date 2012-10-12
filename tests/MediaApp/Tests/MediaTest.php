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

    /**
     * @test
     */
    public function wrongMovieData()
    {
        $postParams = array(
            'customer_username' => 'test',
            'customer_password' => 'testcustomer',
            'filename' => '',
            'protocol' => '',
            'host' => '',
            'username' => 'user',
            'password' => 'pass',
            'filePath' => '/upload/may/');

        $client = $this->createClient();
        $client->request('POST', '/media/add', $postParams);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

}
