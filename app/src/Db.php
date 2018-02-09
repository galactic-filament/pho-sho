<?php namespace Ihsw;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

class Db
{
    private $em;

    public function __construct(array $dbParams)
    {
        $paths = [sprintf('%s/Entity', __DIR__)];

        // creating an annotation metadata driver
        $reader = new AnnotationReader();
        $driver = new AnnotationDriver($reader, $paths);

        // reading the config and loading the metadata driver
        $config = Setup::createAnnotationMetadataConfiguration($paths, true);
        $config->setMetadataDriverImpl($driver);

        $this->em = EntityManager::create($dbParams, $config);
    }

    public function getEntityManager()
    {
        return $this->em;
    }
}
