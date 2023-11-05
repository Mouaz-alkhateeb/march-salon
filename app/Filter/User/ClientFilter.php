<?php

namespace App\Filter\User;

use App\Filter\OthersBaseFilter;

class ClientFilter extends OthersBaseFilter
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
