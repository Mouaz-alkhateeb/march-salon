<?php

namespace App\Statuses;


class UserType
{
    public const SUPER_ADMIN = 1;
    public const ADMIN = 2;
    public const RECEPTION = 3;

    public static array $statuses = [self::SUPER_ADMIN, self::ADMIN, self::RECEPTION];
}
