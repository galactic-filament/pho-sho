<?php

namespace Ihsw;

use Ihsw\Test\AbstractTestCase;

class ApplicationTest extends AbstractTestCase
{
    public function testHomepage()
    {
        $response = $this->request('GET', '/');
        $this->assertEquals('Hello, world!', $response->getContent());
    }

    public function testPing()
    {
        $response = $this->requestJson('GET', '/ping');
        $this->assertEquals('Pong', $response->getContent());
    }

    public function testReflection()
    {
        $body = ['greeting' => 'Hello, world!'];
        $responseContent = json_decode(
            $this->requestJson('POST', '/reflection', json_encode($body))->getContent(),
            true
        );

        $this->assertEquals($body['greeting'], $responseContent['greeting']);
    }
}
