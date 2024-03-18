<?php

ini_set('error_reporting', 1);
ini_set('display_errors', 1);

require_once 'bootstrap.php';

use phpApi\App\Application;
use phpApi\App\Controllers\Controller;

$uri = str_replace('/phpApi/', '', $_SERVER['REQUEST_URI']);

$app = new Application($uri);

$app->get('init', [Controller::class, 'init']);

$app->get('users/list', [Controller::class, 'getUserList']);

$app->get('xdr', [Controller::class, 'getAdmin']);

$app->resolve();


