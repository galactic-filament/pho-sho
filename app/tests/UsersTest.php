<?php

namespace Ihsw;

use Symfony\Component\HttpFoundation\Response;
use Ramsey\Uuid\Uuid;
use Ihsw\Test\AbstractTestCase;

class UsersTest extends AbstractTestCase
{
    public function testCreateUser()
    {
        $client = $this->requestJson(
            'POST',
            '/users',
            json_encode(['email' => sprintf('create-user+%s@example.com', Uuid::uuid4()), 'password' => 'test']),
            [],
            Response::HTTP_CREATED
        );
        $userBody = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue(is_int($userBody['id']));
    }
}
