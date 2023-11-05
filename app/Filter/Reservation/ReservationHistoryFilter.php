<?php

namespace App\Filter\Reservation;

use App\Filter\OthersBaseFilter;

class ReservationHistoryFilter extends OthersBaseFilter

{
    public ?string $date = null;

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): void
    {
        $this->date = $date;
    }
}
