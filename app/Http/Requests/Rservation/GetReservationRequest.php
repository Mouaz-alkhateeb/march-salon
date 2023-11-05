<?php

namespace App\Http\Requests\Rservation;

use App\Filter\Reservation\ReservationFilter;
use Illuminate\Foundation\Http\FormRequest;

class GetReservationRequest extends FormRequest
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
        $reservationFilter = new ReservationFilter();

        if ($this->filled('type')) {
            $reservationFilter->setType($this->input('type'));
        }
        if ($this->filled('expert_id')) {
            $reservationFilter->setExpertId($this->input('expert_id'));
        }
        if ($this->filled('from_date')) {
            $reservationFilter->setFromgDate($this->input('from_date'));
        }
        if ($this->filled('to_date')) {
            $reservationFilter->setToDate($this->input('to_date'));
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
