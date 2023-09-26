<?php

namespace Asko\Shape\Core;

class Session
{
    public function get(string $key): mixed
    {
        return $_SESSION[$key];
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }
}
