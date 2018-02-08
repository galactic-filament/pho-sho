<?php
/**
 * Configuration for doctrine console commands
 * PHP Version 7.1
 * 
 * @category Configuration_Files
 * @package  Ihsw
 * @author   Adrian Parker <ihsw.aparker@gmail.com>
 * @license  MIT License
 * @link     https://ihsw.github.io
 */


require_once __DIR__. "/vendor/autoload.php";

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Ihsw\Db;

$db = new Db(
    [
        'driver' => 'pdo_pgsql',
        'host' => $_SERVER['DATABASE_HOST'],
        'dbname' => 'postgres',
        'user' => 'postgres',
        'password' => ''
    ]
);

return ConsoleRunner::createHelperSet($db->getEntityManager());
