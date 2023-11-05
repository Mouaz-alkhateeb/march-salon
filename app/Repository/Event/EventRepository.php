<?php

namespace App\Repository\Event;

use App\Filter\Event\EventFilter;
use App\Models\Event;
use App\Repository\BaseRepositoryImplementation;
use Illuminate\Support\Facades\DB;

class EventRepository extends BaseRepositoryImplementation
{
    public function getFilterItems($filter)
    {
        $records = Event::query();
        if ($filter instanceof EventFilter) {

            return $records->get();
        }
        return $records->get();
    }

    public function create_event($data)
    {
        DB::beginTransaction();
        try {
            $exixtEvent = Event::where('name', $data['name'])->first();
            if ($exixtEvent) {
                return ['success' => false, 'message' => "Event Has Been Already Exists", 'code' => 500];
            }
            $event = new Event();
            $event->name = $data['name'];
            $event->save();
            DB::commit();

            return ['success' => true, 'data' => $event, 'code' => 200];
        } catch (\Exception $e) {
            DB::rollback();
            return ['success' => false, 'message' => "Event not created,Please Try Again", 'code' => 500];
        }
    }

    public function update_event($data)
    {
        DB::beginTransaction();
        try {
            $event = Event::findOrFail($data['event_id']);

            if (isset($data['name'])) {
                $event->name = $data['name'];
            }
            $event->save();
            DB::commit();
            return ['success' => true, 'data' =>   $event, 'code' => 200];
        } catch (\Exception $e) {

            DB::rollback();
            return ['success' => false, 'message' => "Event not updated,Please Try Again", 'code' => 500];
        }
    }

    public function delete_event(int $id)
    {
        $event = Event::where('id', $id)->first();

        if ($event) {
            $event->delete();
            return response()->json(['message' => 'Event Delete Successfully'], 200);
        } else {
            return response()->json(['message' => 'Event Not Found'], 404);
        }
    }


    public function model()
    {
        return Event::class;
    }
}
