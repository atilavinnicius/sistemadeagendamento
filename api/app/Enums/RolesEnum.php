<?php

namespace App\Enums;

class RolesEnum
{
    const ADMIN = 'admin';
    const CLIENT = 'client';

    public static function getValues()
    {
        return [
            self::ADMIN,
            self::CLIENT,
        ];
    }
}
