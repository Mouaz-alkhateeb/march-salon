<?php

namespace App\Http\Requests\Rservation;

use App\Models\BridePackage;
use App\Models\Event;
use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $events = Event::all();
        return [
            'client_id' => 'required|exists:clients,id',
            'expert_id' => 'required|exists:experts,id',
            'start_time' => 'required',
            'notes' => 'nullable',
            'end_time' => 'required',
            'date' => 'required|date_format:Y-m-d H:i:s',
            'event' => [
                'nullable',
                'array',
            ],
            'event.*' => [
                'required_if:event,!null',
                'in:' . implode(',', Event::pluck('id')->all()),
            ],

            'bride_package' => [
                'nullable',
                'array',
            ],
            'bride_package.*' => [
                'required_if:bride_package,!null',
                'in:' . implode(',', BridePackage::pluck('id')->all()),
            ],

            'service' => [
                'nullable',
                'array',
            ],
            'service.*' => [
                'required_if:service,!null',
                'in:' . implode(',', Service::pluck('id')->all()),
            ],
        ];
    }
}
