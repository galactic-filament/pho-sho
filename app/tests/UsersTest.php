<?php

namespace Ihsw;

use Symfony\Component\HttpFoundation\Response;
use Ramsey\Uuid\Uuid;
use Ihsw\Test\AbstractTestCase;

class UsersTest extends AbstractTestCase
{
    private function createTestUser(string $email)
    {
        $response = $this->requestJson(
            'POST',
            '/users',
            json_encode(['email' => $email, 'password' => 'test'])
        );
        $this->assertEquals($response->getStatusCode(), Response::HTTP_CREATED);
        return json_decode($response->getContent(), true);
    }

    public function testCreateUser()
    {
        $response = $this->requestJson(
            'POST',
            '/users',
            json_encode(['email' => sprintf('create-user+%s@example.com', Uuid::uuid4()), 'password' => 'test'])
        );

        $userBody = json_decode($response->getContent(), true);
        $this->assertTrue(is_int($userBody['id']));
    }

    public function testGetUser()
    {
        $user = $this->createTestUser(sprintf('get-user+%s@example.com', Uuid::uuid4()));

        $response = $this->requestJson('GET', sprintf('/user/%s', $user['id']));
        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
    }

    public function testGetUserNotFound()
    {
        $response = $this->requestJson('GET', '/user/-1');
        $this->assertEquals($response->getStatusCode(), Response::HTTP_NOT_FOUND);
    }

    public function testDeleteUser()
    {
        $user = $this->createTestUser(sprintf('delete-user+%s@example.com', Uuid::uuid4()));

        $response = $this->requestJson('DELETE', sprintf('/user/%s', $user['id']));
        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
    }

    public function testDeleteUserNotFound()
    {
        $response = $this->requestJson('DELETE', '/user/-1');
        $this->assertEquals($response->getStatusCode(), Response::HTTP_NOT_FOUND);
    }

    public function testUpdateUser()
    {
        $user = $this->createTestUser(sprintf('update-user+%s@example.com', Uuid::uuid4()));

        $newBody = ['email' => sprintf('update-user+%s@example.com', Uuid::uuid4())];
        $response = $this->requestJson('PUT', sprintf('/user/%s', $user['id']), json_encode($newBody));
        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
        $body = json_decode($response->getContent(), true);
        $this->assertEquals($body['email'], $newBody['email']);
    }

    public function testUpdateUserNotFound()
    {
        $response = $this->requestJson('PUT', '/user/-1', json_encode([]));
        $this->assertEquals($response->getStatusCode(), Response::HTTP_NOT_FOUND);
    }
}
