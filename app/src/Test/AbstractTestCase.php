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
    $app->error(function(\Exception $e, $code) use($app) {
      return $app->json(['error' => $e->getMessage()], $code);
    });
    return $app->load();
  }

  protected function _testRequest($method, $url, array $headers = [],
    $body = '', $expectedStatus = Response::HTTP_OK)
  {
    $client = $this->createClient();
    $crawler = $client->request($method, $url, [], [], $headers, $body);

    $this->assertEquals(
      $client->getResponse()->getStatusCode(),
      $expectedStatus,
      sprintf('Response is %s: %s', $expectedStatus,
        json_encode($client->getResponse()->getContent()))
    );

    return [$client, $crawler];
  }

  protected function _testJson($method, $url, array $body = [],
    $expectedStatus = Response::HTTP_OK)
  {
    list($client, $crawler) = $this->_testRequest($method, $url, [
      'CONTENT_TYPE' => 'application/json'
    ], json_encode($body), $expectedStatus);

    $res = json_decode($client->getResponse()->getContent(), true);
    $this->assertNotEquals($res, null, 'Json decoding succeeds');

    return [$client, $crawler, $res];
  }
}
