<?php

require_once 'bootstrap.php';

use phpApi\App\Application;
use phpApi\App\Controllers\UserController;
use phpApi\Resolver\Request;
use phpApi\App\Controllers\AuthController;

$uri = Request::decodeExactUri(__DIR__);

$app = new Application($uri);

/** Auth Routes */

$app->get('auth/login', [AuthController::class, 'login']);

$app->get('auth/logout', [AuthController::class, 'logout']);

$app->get('auth/info', [AuthController::class, 'info']);

$app->get('xdr', [AuthController::class, 'info']);

/** User List */

$app->get('user/list', [UserController::class, 'getUserList']);

$app->resolve();


