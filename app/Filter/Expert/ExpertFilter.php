<?php

namespace App\Filter\Expert;

use App\Filter\OthersBaseFilter;

class ExpertFilter extends OthersBaseFilter
{
    public ?string $from_date = null;
    public ?string $to_date = null;
    public ?int $expert_id = null;

    public function getFromDate(): ?string
    {
        return $this->from_date;
    }

    public function setFromgDate(?string $from_date): void
    {
        $this->from_date = $from_date;
    }

    public function getToDate(): ?string
    {
        return $this->to_date;
    }

    public function setToDate(?string $to_date): void
    {
        $this->to_date = $to_date;
    }

    public function getExperttId(): ?int
    {
        return $this->expert_id;
    }

    public function setExpertId(?int $expert_id): void
    {
        $this->expert_id = $expert_id;
    }
}
