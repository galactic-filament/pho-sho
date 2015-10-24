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
}
