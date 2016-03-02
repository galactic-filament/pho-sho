<?php namespace Ihsw;

use Doctrine\ORM\Tools\Setup,
  Doctrine\ORM\EntityManager,
  Doctrine\Common\Annotations\AnnotationReader,
  Doctrine\ORM\Mapping\Driver\AnnotationDriver;

class Db
{
  private $em;

  public function __construct(array $dbParams)
  {
    $key = $_SERVER['ENV'] === 'travis' ? 'travis' : 'local';

    $paths = [sprintf('%s/Entity', __DIR__)];

    // creating an annotation metadata driver
    $reader = new AnnotationReader();
    $driver = new AnnotationDriver($reader, $paths);

    // reading the config and loading the metadata driver
    $config = Setup::createAnnotationMetadataConfiguration($paths, true);
    $config->setMetadataDriverImpl($driver);

    $this->em = EntityManager::create($dbParams[$key], $config);
  }

  public function getEntityManager()
  {
    return $this->em;
  }
}
