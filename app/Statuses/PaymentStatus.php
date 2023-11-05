<?php

namespace App\Statuses;

class PaymentStatus

{
    public const REDUX = 1;
    public const COMPLETED = 2;
    public const DELAYED = 3;


    public static array $statuses = [self::REDUX, self::COMPLETED, self::DELAYED];
}
