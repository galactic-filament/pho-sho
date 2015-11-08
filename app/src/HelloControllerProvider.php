<?php namespace Ihsw;

use Silex\Application as SilexApplication;
use Silex\ControllerProviderInterface;

class HelloControllerProvider implements ControllerProviderInterface
{
  public function connect(SilexApplication $app)
  {
    $controllers = $app['controllers_factory'];
    $controllers->get('/', function (SilexApplication $app) {
      return 'Hello, world!';
    });
    $controllers->get('/ping', function (SilexApplication $app) {
      return 'Pong';
    });
    return $controllers;
  }
}
