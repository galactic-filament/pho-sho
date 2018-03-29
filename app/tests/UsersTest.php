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
}
