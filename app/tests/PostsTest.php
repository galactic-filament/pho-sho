<?php

namespace Ihsw;

use Symfony\Component\HttpFoundation\Response;
use Ihsw\Test\AbstractTestCase;

class PostsTest extends AbstractTestCase
{
    private function createTestPost()
    {
        $client = $this->requestJson(
            'POST',
            '/posts',
            json_encode(['body' => 'Hello, world!']),
            [],
            Response::HTTP_CREATED
        );
        return json_decode($client->getResponse()->getContent(), true);
    }

    public function testCreatePost()
    {
        $client = $this->requestJson(
            'POST',
            '/posts',
            json_encode(['body' => 'Hello, world!']),
            [],
            Response::HTTP_CREATED
        );
        $postBody = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue(is_int($postBody['id']));
    }

    public function testGetPost()
    {
        $createBody = ['body' => 'Hello, world!'];
        $client = $this->requestJson('POST', '/posts', json_encode($createBody), [], Response::HTTP_CREATED);
        $postBody = json_decode($client->getResponse()->getContent(), true);

        $client = $this->requestJson('GET', sprintf('/post/%s', $postBody['id']));
        $getBody = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($createBody['body'], $getBody['body']);
    }

    public function testDeletePost()
    {
        $postBody = $this->createTestPost();
        $client = $this->request('DELETE', sprintf('/post/%s', $postBody['id']));
        $this->assertEquals($client->getResponse()->getStatusCode(), Response::HTTP_OK);
    }

    public function testPutPost()
    {
        $postBody = $this->createTestPost();

        $requestBody = ['body' => 'Jello, world!'];
        $client = $this->requestJson('PUT', sprintf('/post/%s', $postBody['id']), json_encode($requestBody));
        $responseBody = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($requestBody['body'], $responseBody['body']);
    }
}
