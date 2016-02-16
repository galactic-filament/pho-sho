<?php namespace Ihsw;

use Silex\Application as SilexApplication,
  Silex\Provider\MonologServiceProvider;
use Ihsw\HelloControllerProvider,
  Ihsw\Db;
use JMS\Serializer\SerializerBuilder;

class Application extends SilexApplication
{
  private $db;
  private $serializer;

  public function loadAll()
  {
    return $this->loadRoutes()
      ->loadDatabase()
      ->loadSerializer()
      ->loadLogging();
  }

  private function loadRoutes()
  {
    $this->mount('/', new HelloControllerProvider());
    return $this;
  }

  private function loadDatabase()
  {
    $this->db = new Db([
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
    ]);
    return $this;
  }

  private function loadSerializer()
  {
    $this->serializer = SerializerBuilder::create()->build();
    return $this;
  }

  private function loadLogging()
  {
    $this->register(new MonologServiceProvider(), [
      'monolog.logfile' => 'php://stdout',
      'monolog.name' => 'pho-sho'
    ]);
    return $this;
  }

  public function getDb()
  {
    return $this->db;
  }

  public function getSerializer()
  {
    return $this->serializer;
  }
}
