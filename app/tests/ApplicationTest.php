<?php

use Silex\WebTestCase;
use Ihsw\Application;

class ApplicationTest extends WebTestCase
{
  public function createApplication()
  {
    $app = new Application();
    $app['debug'] = true;
    $app->error(function(\Exception $e, $code) use($app) {
      return $app->json(['error' => $e->getMessage()], $code);
    });
    return $app->loadAll();
  }

  private function _testRequest($method, $url, array $headers = [], $body = '')
  {
    $client = $this->createClient();
    $crawler = $client->request($method, $url, [], [], $headers, $body);

    $this->assertTrue($client->getResponse()->isOk(), sprintf(
      'Response is 200 OK: %s',
      json_encode($client->getResponse()->getContent())
    ));

    return [$client, $crawler];
  }

  private function _testJson($method, $url, array $body = [])
  {
    list($client, $crawler) = $this->_testRequest($method, $url, [
      'CONTENT_TYPE' => 'application/json'
    ], json_encode($body));

    $res = json_decode($client->getResponse()->getContent(), true);
    $this->assertNotEquals($res, null, 'Json decoding succeeds');

    return [$client, $crawler, $res];
  }

  private function _createPost($body)
  {
      list(, , $res) = $this->_testJson('POST', '/posts', $body);

      $this->assertTrue(is_int($res['id']));

      return $res;
  }

  public function testHomepage()
  {
    list($client,) = $this->_testRequest('GET', '/');
    $this->assertEquals('Hello, world!', $client->getResponse()->getContent());
  }

  public function testPing()
  {
    list($client,) = $this->_testRequest('GET', '/ping');
    $this->assertEquals('Pong', $client->getResponse()->getContent());
  }

  public function testReflection()
  {
    $body = ['greeting' => 'Hello, world!'];
    list(, , $res) = $this->_testJson(
      'POST',
      '/reflection',
      $body
    );

    $this->assertEquals($body['greeting'], $res['greeting']);
  }

  public function testPosts()
  {
    $this->_createPost(['body' => 'Hello, world!']);
  }

  public function testGetPost()
  {
    $createBody = ['body' => 'Hello, world!'];
    $post = $this->_createPost($createBody);
    list(, , $getBody) = $this->_testJson(
      'GET',
      sprintf('/post/%s', $post['id'])
    );

    $this->assertEquals($createBody['body'], $getBody['body']);
  }

  public function testDeletePost()
  {
    $createBody = ['body' => 'Hello, world!'];
    $post = $this->_createPost($createBody);
    $this->_testJson('DELETE', sprintf('/post/%s', $post['id']));
  }
}
