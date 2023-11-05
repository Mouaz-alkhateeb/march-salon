<?php

namespace App\Statuses;

class ReservationStatus

{
    public const COMPLETED = 1;
    public const CANCELED = 2;
    public const DELAYED = 3;
    public const PENDING = 4;

    public static array $statuses = [self::COMPLETED, self::CANCELED, self::DELAYED, self::PENDING];
public static array $statuses2 = [self::DELAYED, self::PENDING];
    public static array $statuses3 = [self::COMPLETED, self::PENDING, self::DELAYED];
}
