<?php namespace Ihsw;

use Silex\Application as SilexApplication;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class HelloControllerProvider implements ControllerProviderInterface
{
  public function connect(SilexApplication $app)
  {
    // adding json decoding middleware
    $app->before(function(Request $request) {
      if ($request->headers->get('Content-type') !== 'application/json') {
        return;
      }

      $data = json_decode($request->getContent(), true);
      $request->attributes->set('request-body', $data);
    });

    /**
     * setting up the controllers
     */
    // misc
    $controllers = $app['controllers_factory'];

    // route definitions
    $controllers->get('/', function (SilexApplication $app) {
      return 'Hello, world!';
    });
    $controllers->get('/ping', function (SilexApplication $app) {
      return 'Pong';
    });
    $controllers->post(
      '/reflection',
      function (SilexApplication $app, Request $request) {
        return $app->json($request->attributes->get('request-body'));
      }
    );
    $controllers->post(
      '/posts',
      function (SilexApplication $app, Request $request) {
        $req = $request->attributes->get('request-body');

        $statement = $app->getDb()->prepare(
          'INSERT INTO posts (body) VALUES (:body)'
        );
        $statement->execute(['body' => $req['body']]);

        return $app->json([
          'id' => $app->getDb()->lastInsertId('posts_id_seq')
        ]);
      }
    );

    return $controllers;
  }
}
