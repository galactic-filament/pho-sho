<?php
/**
 * Main file for running the API
 * PHP Version 7.1
 * 
 * @category Initialization_Files
 * @package  Ihsw
 * @author   Adrian Parker <ihsw.aparker@gmail.com>
 * @license  MIT License
 * @link     https://ihsw.github.io
 */

require_once __DIR__. "/../vendor/autoload.php";

use Ihsw\Application;

$app = new Application();
$app->load()->run();
