<?php

namespace App\Http\Controllers\Api;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Controllers\Controller;
use App\Http\Requests\Event\CreateEventRequest;
use App\Http\Requests\Event\GetEventsListRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Http\Resources\Event\EventResource;
use App\Services\Event\EventService;

class EventController extends Controller
{
    public function __construct(private EventService $eventService)
    {
    }
    public function create_event(CreateEventRequest $request)
    {
        $createdData = $this->eventService->create_event($request->validated());
        if ($createdData['success']) {
            $returnData = EventResource::make($createdData['data']);

            return ApiResponseHelper::sendResponse(
                new Result($returnData, "Done")
            );
        } else {
            return ApiResponseHelper::sendFailedResponse($createdData['message'], $createdData['code']);
        }
    }

    public function update_event(UpdateEventRequest $request)
    {

        $createdData = $this->eventService->update_event($request->validated());
        if ($createdData['success']) {
            $returnData = EventResource::make($createdData['data']);

            return ApiResponseHelper::sendResponse(
                new Result($returnData, "Done")
            );
        } else {
            return ApiResponseHelper::sendFailedResponse($createdData['message'], $createdData['code']);
        }
    }

    public function delete_event($id)
    {
        $deletionResult = $this->eventService->delete_event($id);

        if ($deletionResult) {
            return $deletionResult;
        } else {
            return response()->json(['message' => 'Error Deleting Event,Please Try Again'], 500);
        }
    }
    public function show($id)
    {

        $createdData = $this->eventService->show($id);

        $returnData = EventResource::make($createdData);

        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }

    public function get_events_list(GetEventsListRequest $request)
    {
        $data = $this->eventService->get_events_list($request->generateFilter());
        $returnData = EventResource::collection($data);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "DONE")
        );
    }
}
