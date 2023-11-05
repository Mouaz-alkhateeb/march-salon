<?php

namespace App\Filter\Transfer;

use App\Filter\OthersBaseFilter;

class TransferFilter extends OthersBaseFilter
{
    public ?string $starting_date = null;
    public ?string $end_date = null;
    public ?int $user_id = null;
    public ?int $client_id = null;
    public ?string $transfer_amount = null;

    public function getStartingDate(): ?string
    {
        return $this->starting_date;
    }

    public function setStartingDate(?string $starting_date): void
    {
        $this->starting_date = $starting_date;
    }

    public function getTransferAmount(): ?string
    {
        return $this->transfer_amount;
    }

    public function setTransferAmount(?string $transfer_amount): void
    {
        $this->transfer_amount = $transfer_amount;
    }

    public function getEndingDate(): ?string
    {
        return $this->end_date;
    }

    public function setEndingDate(?string $end_date): void
    {
        $this->end_date = $end_date;
    }


    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getClientId(): ?int
    {
        return $this->client_id;
    }

    public function setClientId(?int $client_id): void
    {
        $this->client_id = $client_id;
    }
}