<?php namespace Ihsw\Test;

use Silex\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Ihsw\Application;

abstract class AbstractTestCase extends WebTestCase
{
    public function createApplication()
    {
        $app = new Application();
        $app['debug'] = true;
        $app->error(function (\Exception $e, $code) use ($app) {
            printf("error: %s\n", $e->getMessage());
            return $app->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
        return $app->load();
    }

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
}
