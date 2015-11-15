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

    // setting up the controllers
    $controllers = $app['controllers_factory'];
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
    return $controllers;
  }
}
