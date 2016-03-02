<?php namespace Ihsw\Test;

use Silex\WebTestCase;
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

  protected function _testRequest($method, $url, array $headers = [], $body = '')
  {
    $client = $this->createClient();
    $crawler = $client->request($method, $url, [], [], $headers, $body);

    $this->assertTrue($client->getResponse()->isOk(), sprintf(
      'Response is 200 OK: %s',
      json_encode($client->getResponse()->getContent())
    ));

    return [$client, $crawler];
  }

  protected function _testJson($method, $url, array $body = [])
  {
    list($client, $crawler) = $this->_testRequest($method, $url, [
      'CONTENT_TYPE' => 'application/json'
    ], json_encode($body));

    $res = json_decode($client->getResponse()->getContent(), true);
    $this->assertNotEquals($res, null, 'Json decoding succeeds');

    return [$client, $crawler, $res];
  }
}
