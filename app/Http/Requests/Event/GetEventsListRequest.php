<?php

namespace App\Http\Requests\Event;

use App\Filter\Event\EventFilter;
use Illuminate\Foundation\Http\FormRequest;

class GetEventsListRequest extends FormRequest
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
        $eventFilter = new EventFilter();

        if ($this->filled('order_by')) {
            $eventFilter->setOrderBy($this->input('order_by'));
        }

        if ($this->filled('order')) {
            $eventFilter->setOrder($this->input('order'));
        }

        if ($this->filled('per_page')) {
            $eventFilter->setPerPage($this->input('per_page'));
        }
        return $eventFilter;
    }
}
