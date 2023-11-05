<?php

namespace App\Statuses;

class PaymentWay

{
    public const CASH = 1;
    public const CONVERTED = 2;
    public const NETWORK = 3;

    public static array $statuses = [self::CASH, self::CONVERTED, self::NETWORK];
}
