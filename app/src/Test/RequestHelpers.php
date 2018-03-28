<?php namespace Ihsw\Test;

use Symfony\Component\HttpFoundation\Response;

trait RequestHelpers
{
    protected function generateTestFunc($headerOptions = [], $expectedStatusOption = Response::HTTP_OK)
    {
        return function (
            $method,
            $url,
            $body = '',
            $headers = [],
            $expectedStatus = null
        ) use (
            $headerOptions,
            $expectedStatusOption
        ) {
            $headers = array_merge($headers, $headerOptions);

            if ($expectedStatus === null) {
                $expectedStatus = $expectedStatusOption;
            }

            $client = $this->createClient();
            $client->request($method, $url, [], [], $headers, $body);
            $this->assertEquals($expectedStatus, $client->getResponse()->getStatusCode());

            return $client;
        };
    }

    protected function generateTestJsonFunc($headerOptions = [], $expectedStatusOption = Response::HTTP_OK)
    {
        return $this->generateTestFunc(
            array_merge(['CONTENT_TYPE' => 'application/json'], $headerOptions),
            $expectedStatusOption
        );
    }

    protected function request($method, $url, $body = '', $headers = [], $expectedStatus = null)
    {
        return $this->generateTestFunc()($method, $url, $body, $headers, $expectedStatus);
    }

    protected function requestJson($method, $url, $body = '', $headers = [], $expectedStatus = null)
    {
        return $this->generateTestJsonFunc()($method, $url, $body, $headers, $expectedStatus);
    }
}
