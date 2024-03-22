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
    foreach (func_get_args() as $arg) {
        print_r($arg);
    }

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

function request($key = null)
{
    $request = (new \phpApi\Resolver\Request);

    return $key ? $request->get($key) : $request ;
}

function srcPath($path): string
{
    return __DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.$path;
}