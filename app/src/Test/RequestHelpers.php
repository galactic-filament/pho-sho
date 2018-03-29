<?php namespace Ihsw\Test;

use Symfony\Component\HttpFoundation\Response;

trait RequestHelpers
{
    protected function requestGenerator($headerOptions = [])
    {
        return function ($method, $url, $body = '', $headers = []) use ($headerOptions) {
            $headers = array_merge($headers, $headerOptions);

            $client = $this->createClient();
            $client->request($method, $url, [], [], $headers, $body);

            return $client->getResponse();
        };
    }

    protected function jsonRequestGenerator($headerOptions = [])
    {
        return $this->requestGenerator(array_merge(['CONTENT_TYPE' => 'application/json'], $headerOptions));
    }

    protected function request($method, $url, $body = '', $headers = [])
    {
        return $this->requestGenerator()($method, $url, $body, $headers);
    }

    protected function requestJson($method, $url, $body = '', $headers = [])
    {
        return $this->jsonRequestGenerator()($method, $url, $body, $headers);
    }
}
