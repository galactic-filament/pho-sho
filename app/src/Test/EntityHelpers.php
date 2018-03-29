<?php namespace Ihsw\Test;

use Symfony\Component\HttpFoundation\Response;

trait EntityHelpers
{
    protected function requestPost($body)
    {
        return $this->requestJson('POST', '/posts', json_encode($body));
    }

    protected function requestUser($body)
    {
        return $this->requestJson('POST', '/users', json_encode($body));
    }
}
