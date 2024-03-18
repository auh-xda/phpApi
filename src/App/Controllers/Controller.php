<?php

namespace phpApi\App\Controllers;

use phpApi\Resolver\Cookie;
use phpApi\App\Models\Model;
use phpApi\Resolver\Response;

class Controller
{
    public function init()
    {
        return response()->view('');
    }

    public function getUserList(): Response
    {
        $model = new Model('users');

        $users = $model->get();

        return successResponse('sss', $users);
    }

    public function getAdmin(): Response
    {
        return successResponse('adminArea', users()->select(['id','email', 'role'])->get());
    }
}