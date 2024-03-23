<?php

namespace phpApi\Resolver;

class Hash
{
    public static function verify($plain, $hash): bool
    {
        return password_verify($plain, $hash);
    }

    public static function make($password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}