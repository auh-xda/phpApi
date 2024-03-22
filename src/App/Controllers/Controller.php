<?php

namespace phpApi\App\Controllers;

use phpApi\Resolver\Response;

class Controller
{
    public function init(): Response
    {
        return response()->success();
    }

    public function getUserList(): Response
    {
        return successResponse('sss', users()->get());
    }

    public function getAdmin(): Response
    {
        return successResponse('adminArea', users()->select(['id','email', 'role'])->get());
    }
}