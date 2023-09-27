<?php

namespace Asko\Shape\Core\Services;

use Asko\Shape\Core\Models\User;

class AuthService
{
    public static function isAuthenticated(string $auth_token): bool
    {
        return User::where("auth_token", $auth_token)->exists();
    }

    public static function authenticates(string $email, string $password): string|false
    {
        $user = User::where("email", $email)->first();

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user->password)) {
            return false;
        }

        $token = bin2hex(random_bytes(32));
        $user->auth_token = $token;
        $user->save();

        return $token;
    }
}
