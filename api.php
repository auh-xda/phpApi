<?php

require_once 'bootstrap.php';

use phpApi\App\Application;
use phpApi\App\Controllers\Controller;
use phpApi\Resolver\Request;

$uri = Request::decodeExactUri(__DIR__);

$app = new Application($uri);

$app->get('init', [Controller::class, 'init']);

$app->get('users', [Controller::class, 'getUserList']);

$app->get('xdr', [Controller::class, 'getAdmin']);

$app->resolve();


