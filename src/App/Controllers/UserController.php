<?php

namespace phpApi\App\Controllers;

class UserController extends Controller
{
    public function getUserList(): \phpApi\Resolver\Response
    {
        $search = $this->request('search-query');

        $users = model('users')->where('active', 1)
            ->where('email', 'LIKE', "%$search%")
            ->orWhere('name', 'LIKE', "%$search%")
            ->orWhere('phone', 'LIKE', "%$search%");

        return successResponse('', $users->get());
    }
}