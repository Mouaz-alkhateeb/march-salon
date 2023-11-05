<?php

namespace App\Statuses;

class HavePermission
{
    public const TRUE = 1;
    public const FALSE = 0;

    public static array $statuses = [self::TRUE, self::FALSE];
}
