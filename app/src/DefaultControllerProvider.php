<?php namespace Ihsw;

use Silex\Application as SilexApplication,
  Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Ihsw\Application;

class DefaultControllerProvider implements ControllerProviderInterface
{
  public function connect(SilexApplication $app)
  {
    // misc
    $controllers = $app['controllers_factory'];

    // route definitions
    $controllers->get('/', function (Application $app) {
      return $app->plain('Hello, world!');
    });
    $controllers->get('/ping', function (Application $app) {
      return $app->plain('Pong');
    });
    $controllers->post(
      '/reflection',
      function (Application $app, Request $request) {
        return $app->json($request->attributes->get('request-body'));
      }
    );

    return $controllers;
  }
}
