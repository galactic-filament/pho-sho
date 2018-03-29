<?php

namespace Ihsw;

use Symfony\Component\HttpFoundation\Response;
use Ihsw\Test\AbstractTestCase;

class PostsTest extends AbstractTestCase
{
    private function createTestPost()
    {
        $response = $this->requestPost(['body' => 'Hello, world!']);
        $this->assertEquals($response->getStatusCode(), Response::HTTP_CREATED);
        return json_decode($response->getContent(), true);
    }

    public function testCreatePost()
    {
        $response = $this->requestJson('POST', '/posts', json_encode(['body' => 'Hello, world!']));
        $this->assertEquals($response->getStatusCode(), Response::HTTP_CREATED);

        $post = json_decode($response->getContent(), true);
        $this->assertTrue(is_int($post['id']));
    }

    public function testGetPost()
    {
        $post = $this->createTestPost();

        $response = $this->requestJson('GET', sprintf('/post/%s', $post['id']));
        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
        $body = json_decode($response->getContent(), true);
        $this->assertEquals($post['body'], $body['body']);
    }

    public function testDeletePost()
    {
        $post = $this->createTestPost();

        $response = $this->request('DELETE', sprintf('/post/%s', $post['id']));
        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
    }

    public function testPutPost()
    {
        $post = $this->createTestPost();

        $requestBody = ['body' => 'Jello, world!'];
        $response = $this->requestJson('PUT', sprintf('/post/%s', $post['id']), json_encode($requestBody));
        $responseBody = json_decode($response->getContent(), true);
        $this->assertEquals($requestBody['body'], $responseBody['body']);
    }
}
