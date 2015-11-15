<?php

use Silex\WebTestCase;
use Ihsw\Application;

class ApplicationTest extends WebTestCase
{
  public function createApplication()
  {
    $app = new Application();
    return $app->loadRoutes();
  }

  public function testHomepage()
  {
    $client = $this->createClient();
    $crawler = $client->request('GET', '/');
    $this->assertTrue($client->getResponse()->isOk());
    $this->assertEquals('Hello, world!', $client->getResponse()->getContent());
  }

  public function testPing()
  {
    $client = $this->createClient();
    $crawler = $client->request('GET', '/ping');
    $this->assertTrue($client->getResponse()->isOk());
    $this->assertEquals('Pong', $client->getResponse()->getContent());
  }

  public function testReflection()
  {
    $body = ['greeting' => 'Hello, world!'];
    $client = $this->createClient();
    $crawler = $client->request('POST', '/reflection', [], [], [
      'CONTENT_TYPE' => 'application/json'
    ], json_encode($body));

    $this->assertTrue($client->getResponse()->isOk());

    $res = json_decode($client->getResponse()->getContent(), true);
    $this->assertNotEquals($res, null);
    $this->assertEquals($body['greeting'], $res['greeting']);
  }
}
