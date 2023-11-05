<?php

namespace App\Statuses;

class PermissionType
{
    public const DELAY = 1;
    public const CANCLE = 2;
    public const UPDATE = 3;

    public static array $statuses = [self::DELAY, self::CANCLE, self::UPDATE];
}
