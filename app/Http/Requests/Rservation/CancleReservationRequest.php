<?php

namespace App\Http\Requests\Rservation;

use App\Statuses\ReasonCancleDelay;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CancleReservationRequest extends FormRequest
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
        return [
            'reservation_id' => 'required|exists:reservations,id',
            // 'reason_cancle' => ['required', Rule::in(ReasonCancleDelay::$statuses)],
            'reason_cancle' => 'required|string',
        ];
    }
}
