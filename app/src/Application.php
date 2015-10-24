<?php namespace Ihsw;

use Silex\Application as SilexApplication;
use Ihsw\HelloControllerProvider;

class Application extends SilexApplication
{
  public function loadRoutes()
  {
    $this->mount('/', new HelloControllerProvider());
    return $this;
  }
}
