<?php

declare(strict_types=1);

namespace App\Service;

class AliasGenerator
{
    private const CHAR_STORAGE = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public static function generate(int $char = 5): string
    {
        $randString = '';

        for ($i = 0; $i < $char; $i++) {
            $randString .= static::CHAR_STORAGE[rand(0, strlen(static::CHAR_STORAGE) -1)];
        }

        return $randString;
    }
}