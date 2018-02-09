<?php

use Symfony\Component\HttpFoundation\Response;
use Ihsw\Test\AbstractTestCase;

class PostsTest extends AbstractTestCase
{
    private function createTestPost($body)
    {
        list(, , $res) = $this->_testJson('POST', '/posts', $body, Response::HTTP_CREATED);
        $this->assertTrue(is_int($res['id']));

        return $res;
    }

    public function testPosts()
    {
        $this->createTestPost(['body' => 'Hello, world!']);
    }

    public function testGetPost()
    {
        $createBody = ['body' => 'Hello, world!'];
        $post = $this->createTestPost($createBody);

        list(, , $getBody) = $this->_testJson('GET', sprintf('/post/%s', $post['id']));
        $this->assertEquals($createBody['body'], $getBody['body']);
    }

    public function testDeletePost()
    {
        $createBody = ['body' => 'Hello, world!'];
        $post = $this->createTestPost($createBody);
        $this->_testJson('DELETE', sprintf('/post/%s', $post['id']));
    }

    public function testPutPost()
    {
        $createBody = ['body' => 'Hello, world!'];
        $post = $this->createTestPost($createBody);

        $requestBody = ['body' => 'Jello, world!'];
        list(, , $responseBody) = $this->_testJson('PUT', sprintf('/post/%s', $post['id']), $requestBody);
        $this->assertEquals($requestBody['body'], $responseBody['body']);
    }
}
