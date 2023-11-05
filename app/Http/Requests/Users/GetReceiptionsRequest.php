<?php

namespace App\Http\Requests\Users;

use App\Filter\User\UserFilter;
use Illuminate\Foundation\Http\FormRequest;

class GetReceiptionsRequest extends FormRequest
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
        $userFilter = new UserFilter();


        if ($this->filled('order_by')) {
            $userFilter->setOrderBy($this->input('order_by'));
        }

        if ($this->filled('order')) {
            $userFilter->setOrder($this->input('order'));
        }

        if ($this->filled('per_page')) {
            $userFilter->setPerPage($this->input('per_page'));
        }
        return $userFilter;
    }
}
