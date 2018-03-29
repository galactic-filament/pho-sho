<?php

namespace Ihsw;

use Symfony\Component\HttpFoundation\Response;
use Ramsey\Uuid\Uuid;
use Ihsw\Test\AbstractTestCase;

class UsersTest extends AbstractTestCase
{
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
}
