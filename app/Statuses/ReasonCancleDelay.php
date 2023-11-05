<?php

namespace App\Statuses;

class ReasonCancleDelay

{
    public const OSSASION = 1;
    public const POOR_SERVICE = 2;
    public const CASE_OF_DEATH = 3;
    public const OTHERS = 4;

    public static array $statuses = [self::OSSASION, self::POOR_SERVICE, self::CASE_OF_DEATH, self::OTHERS];
}
