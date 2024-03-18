<?php

use phpApi\App\Models\Model;
use phpApi\Resolver\Response;

function enableDebugging(): void
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

function users(): Model
{
    return model('users');
}


function model($table): Model
{
    return new Model($table);
}

function dd()
{
    print_r(...func_get_args());
    die(PHP_EOL);
}

function successResponse($message = '', $data = []): Response
{
    return response()->success()->json([
        'message' => $message, 'data' => $data
    ]);
}

function errorResponse($message): Response
{
    return response()->error()->json([
        'message' => $message
    ]);
}

function response(): Response
{
    return new Response();
}