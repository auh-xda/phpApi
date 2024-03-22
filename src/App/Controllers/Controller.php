<?php

namespace phpApi\App\Controllers;

use phpApi\App\Models\Model;
use phpApi\Resolver\Response;

class Controller
{
    public function init(): Response
    {
        return response()->success();
    }

    public function getUserList(): Response
    {
        $users = model('users')->get();

        return successResponse('userList', $users);
    }

    public function getAdmin(): Response
    {
        return successResponse('adminArea', users()->select(['id','email', 'role'])->get());
    }
}