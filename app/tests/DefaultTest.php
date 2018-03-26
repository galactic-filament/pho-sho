<?php

namespace Ihsw;

use Ihsw\Test\AbstractTestCase;

class ApplicationTest extends AbstractTestCase
{
    public function testHomepage()
    {
        $client = $this->generateTestFunc()('GET', '/');
        $this->assertEquals('Hello, world!', $client->getResponse()->getContent());
    }

    public function testPing()
    {
        $client = $this->generateTestFunc()('GET', '/ping');
        $this->assertEquals('Pong', $client->getResponse()->getContent());
    }

    public function testReflection()
    {
        $client = $this->generateTestJsonFunc()('POST', '/reflection', json_encode(['greeting' => 'Hello, world!']));
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals($body['greeting'], $res['greeting']);
    }
}
