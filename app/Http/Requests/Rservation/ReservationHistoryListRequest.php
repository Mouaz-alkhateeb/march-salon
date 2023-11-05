<?php

namespace App\Http\Requests\Rservation;

use App\Filter\Reservation\ReservationHistoryFilter;
use Illuminate\Foundation\Http\FormRequest;

class ReservationHistoryListRequest extends FormRequest
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
            //
        ];
    }
    public function generateFilter()
    {
        $reservationFilter = new ReservationHistoryFilter();

        if ($this->filled('date')) {
            $reservationFilter->setDate($this->input('date'));
        }
        if ($this->filled('order_by')) {
            $reservationFilter->setOrderBy($this->input('order_by'));
        }

        if ($this->filled('order')) {
            $reservationFilter->setOrder($this->input('order'));
        }

        if ($this->filled('per_page')) {
            $reservationFilter->setPerPage($this->input('per_page'));
        }
        return $reservationFilter;
    }
}
