<?php

namespace App\Services\Event;

use App\Filter\Event\EventFilter;
use App\Interfaces\Event\EventServiceInterface;
use App\Repository\Event\EventRepository;

class EventService implements EventServiceInterface
{
    public function __construct(private EventRepository $eventRepository)
    {
    }

    public function create_event($data)
    {
        return $this->eventRepository->create_event($data);
    }

    public function update_event($data)
    {
        return $this->eventRepository->update_event($data);
    }

    public function delete_event(int $id)
    {
        return $this->eventRepository->delete_event($id);
    }

    public function get_events_list(EventFilter $eventFilter = null)
    {
        if ($eventFilter != null)
            return $this->eventRepository->getFilterItems($eventFilter);
        else
            return $this->eventRepository->get();
    }

    public function show(int $id)
    {

        return $this->eventRepository->getById($id);
    }
}
