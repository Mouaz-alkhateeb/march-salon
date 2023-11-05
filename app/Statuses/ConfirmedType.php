<?php

namespace App\Statuses;

class ConfirmedType

{
    public const UN_CONFIRMED = 0;
    public const CONFIRMED = 1;
    public const NOT_COMMING = 2;


    public static array $statuses = [self::UN_CONFIRMED, self::CONFIRMED, self::NOT_COMMING];
}
