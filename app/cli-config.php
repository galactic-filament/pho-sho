<?php

require_once __DIR__. "/vendor/autoload.php";

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Ihsw\Db;

$db = new Db([
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

return ConsoleRunner::createHelperSet($db->getEntityManager());
