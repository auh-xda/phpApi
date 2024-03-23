<?php

namespace phpApi\App\Controllers;

use phpApi\Resolver\Auth;
use phpApi\Resolver\Hash;

class AuthController extends Controller
{
    public function login(): \phpApi\Resolver\Response
    {
        $email = $this->request('email');
        $password = $this->request('password');

        $user = users()->where('email', $email)->first();

        if (!empty($user) && Hash::verify($password, $user['password'])) {
            return successResponse('Logged In Successfully', Auth::login($user));
        }

        return errorResponse('Invalid Credentials');
    }


    public function logout(): \phpApi\Resolver\Response
    {
        Auth::logout();
        return successResponse('Logged Out Successfully');
    }

    public function info(): \phpApi\Resolver\Response
    {
        return successResponse('Logged in User Info', Auth::info() ?? []);
    }
}