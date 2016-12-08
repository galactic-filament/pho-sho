<?php

use Ihsw\Test\AbstractTestCase;

class ApplicationTest extends AbstractTestCase
{
  public function testHomepage()
  {
    list($client,) = $this->_testRequest('GET', '/');
    $this->assertEquals('Hello, world!', $client->getResponse()->getContent());
  }

  public function testPing()
  {
    list($client,) = $this->_testRequest('GET', '/ping');
    $this->assertEquals('Pong', $client->getResponse()->getContent());
  }

  public function testReflection()
  {
    $body = ['greeting' => 'Hello, world!'];
    list(, , $res) = $this->_testJson('POST', '/reflection', $body);

    $this->assertEquals($body['greeting'], $res['greeting']);
  }
}
