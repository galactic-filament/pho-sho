<?php namespace Ihsw;

use Silex\Application as SilexApplication,
  Silex\Provider\DoctrineServiceProvider;
use Ihsw\HelloControllerProvider;

class Application extends SilexApplication
{
  public function loadAll()
  {
    return $this->loadRoutes()->loadDatabase();
  }

  private function loadRoutes()
  {
    $this->mount('/', new HelloControllerProvider());
    return $this;
  }

  private function loadDatabase()
  {
    $this->register(new DoctrineServiceProvider(), [
      'dbs.options' => [
        'travis' => [
          'driver' => 'pdo_pgsql',
          'host' => 'localhost',
          'dbname' => 'postgres',
          'user' => 'postgres',
          'password' => ''
        ],
        'local' => [
          'driver' => 'pdo_pgsql',
          'host' => 'db',
          'dbname' => 'postgres',
          'user' => 'postgres',
          'password' => ''
        ]
      ]
    ]);
    return $this;
  }

  public function getDb()
  {
    $key = $_SERVER['ENV'] === 'travis' ? 'travis' : 'local';
    return $this['dbs'][$key];
  }
}
