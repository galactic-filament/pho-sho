<?php

require_once __DIR__. "/../vendor/autoload.php";

use Ihsw\Application;

$app = new Application();
$app->load()->run();
