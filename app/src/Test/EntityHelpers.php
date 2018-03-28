<?php namespace Ihsw\Test;

use Symfony\Component\HttpFoundation\Response;

trait EntityHelpers
{
    protected function requestPost($body)
    {
        $client = $this->requestJson('POST', '/posts', json_encode($body), [], Response::HTTP_CREATED);
        $postBody = json_decode($client->getResponse()->getContent(), true);

        return $postBody;
    }
}
