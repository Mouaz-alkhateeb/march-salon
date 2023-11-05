<?php

namespace App\Statuses;

class EventTypes
{
    public const CreateReservation = 'create-reservation';
    public const CompleteReservation = 'complete-reservation';
    public const CreateClient = 'create-client';
    public const CreateExpert = 'create-expert';
    public const CreateHoliday = 'create-holiday';
    public const CancelReservation = 'cancel-reservation';
    public const CreateTransfer = 'create-transfer';
    public const DelayReservation = 'delay-reservation';
    public const UpdateTransfer = 'update-transfer';
    public const CreateReciption = 'create-reciption';
}
