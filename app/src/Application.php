<?php namespace Ihsw;

use Silex\Application as SilexApplication;
use Ihsw\HelloControllerProvider,
  Ihsw\Db;
use JMS\Serializer\SerializerBuilder;
use Monolog\Logger,
  Monolog\Handler\StreamHandler;

class Application extends SilexApplication
{
  private $db;
  private $serializer;
  private $logger;

  public function loadAll()
  {
    return $this->loadRoutes();
  }

  private function loadRoutes()
  {
    $this->mount('/', new HelloControllerProvider());
    return $this;
  }

  public function getDb()
  {
    if (!is_null($this->db)) {
      return $this->db;
    }

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
    return $this->db;
  }

  public function getSerializer()
  {
    if (!is_null($this->serializer)) {
      return $this->serializer;
    }

    $this->serializer = SerializerBuilder::create()->build();
    return $this->serializer;
  }

  public function getLogger()
  {
    if (!is_null($this->logger)) {
      return $this->logger;
    }

    $logger = new Logger('pho-sho');
    $logger->pushHandler(new StreamHandler('php://stdout', Logger::INFO));
    $this->logger = $logger;
    return $this->logger;
  }
}
