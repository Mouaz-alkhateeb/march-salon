<?php

namespace App\Http\Requests\Users;

use App\Filter\User\ClientFilter;
use Illuminate\Foundation\Http\FormRequest;

class GetClientsRequest extends FormRequest
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
        $clientFilter = new ClientFilter();


        if ($this->filled('order_by')) {
            $clientFilter->setOrderBy($this->input('order_by'));
        }

        if ($this->filled('order')) {
            $clientFilter->setOrder($this->input('order'));
        }

        if ($this->filled('per_page')) {
            $clientFilter->setPerPage($this->input('per_page'));
        }
        return $clientFilter;
    }
}
