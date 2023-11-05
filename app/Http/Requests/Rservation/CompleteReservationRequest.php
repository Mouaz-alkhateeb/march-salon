<?php

namespace App\Http\Requests\Rservation;

use App\Statuses\AmountType;
use App\Statuses\PaymentStatus;
use App\Statuses\PaymentWay;
use App\Statuses\ReasonCancleDelay;
use App\Statuses\ReservationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class   CompleteReservationRequest extends FormRequest
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
            'payment_status' => ['nullable', Rule::in(PaymentStatus::$statuses)],
            'payment_way' => ['nullable', Rule::in(PaymentWay::$statuses)],
            'status' => ['nullable', Rule::in(ReservationStatus::$statuses)],
            // 'delay_date' => 'nullable',
            'reservation_amount' => 'required',
            'notes' => 'nullable',
            'attachment' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
        ];
    }
}
