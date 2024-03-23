<?php

namespace phpApi\Resolver;

class Auth
{
    public static function login($user)
    {
        $_SESSION['user'] = $user;
        return $_SESSION['user'];
    }

    public static function logout()
    {
        unset($_SESSION['user']);
    }

    public static function info()
    {
        return $_SESSION['user'];
    }
}