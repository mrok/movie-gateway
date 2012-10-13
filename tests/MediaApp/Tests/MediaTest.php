<?php

namespace MediaApp\Tests;

use Silex\WebTestCase;

class MediaTest extends WebTestCase
{
    public function createApplication()
    {
        return require __DIR__ . '/../../bootstrap.php';
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

    /**
     * @test
     */
    public function correctData()
    {
        $app = $this->createApplication();

        $mediaPublisherMock = $this->getMock('Mrok\Model\MessagePublisher', array('publish'), array(), '', false);
        $mediaPublisherMock->expects($this->once())
            ->method('publish');
        $app['rabbitMQ.queues'] = $app->protect(function ($qname) use ($mediaPublisherMock)
        {
            return $mediaPublisherMock;
        });

        $this->app = $app; //override created app

        $postParams = array(
            'customer_username' => 'test',
            'customer_password' => 'testcustomer',
            'filename' => 'rabbit.mp4',
            'protocol' => 'ftp',
            'host' => 'example.com',
            'username' => 'user',
            'password' => 'pass',
            'filePath' => '/upload/may/');

        $client = $this->createClient();
        $client->request('POST', '/media/add', $postParams);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}
