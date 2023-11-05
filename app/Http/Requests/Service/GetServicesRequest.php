<?php

namespace App\Http\Requests\Service;

use App\Filter\Service\ServiceFilter;
use Illuminate\Foundation\Http\FormRequest;

class GetServicesRequest extends FormRequest
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
        $serviceFilter = new ServiceFilter();


        if ($this->filled('order_by')) {
            $serviceFilter->setOrderBy($this->input('order_by'));
        }

        if ($this->filled('order')) {
            $serviceFilter->setOrder($this->input('order'));
        }

        if ($this->filled('per_page')) {
            $serviceFilter->setPerPage($this->input('per_page'));
        }
        return $serviceFilter;
    }
}
