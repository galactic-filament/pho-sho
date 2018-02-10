<?php

namespace Ihsw;

use Ihsw\Test\AbstractTestCase;

class ApplicationTest extends AbstractTestCase
{
    public function testHomepage()
    {
        list($client,) = $this->generateTestRequest('GET', '/');
        $this->assertEquals('Hello, world!', $client->getResponse()->getContent());
    }

    public function testPing()
    {
        list($client,) = $this->generateTestRequest('GET', '/ping');
        $this->assertEquals('Pong', $client->getResponse()->getContent());
    }

    public function testReflection()
    {
        $body = ['greeting' => 'Hello, world!'];
        list(, , $res) = $this->generateTestJsonRequest('POST', '/reflection', $body);

        $this->assertEquals($body['greeting'], $res['greeting']);
    }
}
