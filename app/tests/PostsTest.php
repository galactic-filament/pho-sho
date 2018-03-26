<?php

namespace Ihsw;

use Symfony\Component\HttpFoundation\Response;
use Ihsw\Test\AbstractTestCase;

class PostsTest extends AbstractTestCase
{
    private function createTestPost($body)
    {
        $client = $this->generateTestJsonFunc()('POST', '/posts', json_encode($body), [], Response::HTTP_CREATED);
        $postBody = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue(is_int($postBody['id']));

        return $postBody;
    }

    public function testPosts()
    {
        $this->createTestPost(['body' => 'Hello, world!']);
    }

    public function testGetPost()
    {
        $createBody = ['body' => 'Hello, world!'];
        $postBody = $this->createTestPost($createBody);

        $client = $this->generateTestJsonFunc()('GET', sprintf('/post/%s', $postBody['id']));
        $getBody = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($createBody['body'], $getBody['body']);
    }

    public function testDeletePost()
    {
        $createBody = ['body' => 'Hello, world!'];
        $postBody = $this->createTestPost($createBody);
        $this->generateTestJsonFunc()('DELETE', sprintf('/post/%s', $postBody['id']));
    }

    public function testPutPost()
    {
        $createBody = ['body' => 'Hello, world!'];
        $postBody = $this->createTestPost($createBody);

        $requestBody = ['body' => 'Jello, world!'];
        $client = $this->generateTestJsonFunc()('PUT', sprintf('/post/%s', $postBody['id']), json_encode($requestBody));
        $responseBody = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($requestBody['body'], $responseBody['body']);
    }
}
