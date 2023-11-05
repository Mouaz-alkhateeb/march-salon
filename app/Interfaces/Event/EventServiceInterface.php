<?php

namespace App\Interfaces\Event;

use App\Filter\Event\EventFilter;

interface EventServiceInterface
{
    public function create_event($data);
    public function update_event($data);
    public function delete_event(int $id);
    public function get_events_list(EventFilter $eventFilter = null);
}
