<?php namespace Ihsw;

use Doctrine\ORM\Tools\Setup,
  Doctrine\ORM\EntityManager;

class Db
{
  private $em;

  public function __construct(array $dbParams)
  {
    $key = $_SERVER['ENV'] === 'travis' ? 'travis' : 'local';
    $config = Setup::createYAMLMetadataConfiguration(
      [sprintf('%s/../entity-src/models', __DIR__)],
      true
    );
    $this->em = EntityManager::create($dbParams[$key], $config);
  }

  public function getEntityManager()
  {
    return $this->em;
  }
}
