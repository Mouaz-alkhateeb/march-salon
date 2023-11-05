<?php

namespace App\Statuses;

class ReservationType
{
    public const APPROVED = 1;
    public const UN_APPROVED = 2;

    public static array $statuses = [self::APPROVED, self::UN_APPROVED];
}
