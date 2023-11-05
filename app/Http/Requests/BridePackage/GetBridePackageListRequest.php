<?php

namespace App\Http\Requests\BridePackage;

use App\Filter\BridePackege\BridePackegeFilter;
use Illuminate\Foundation\Http\FormRequest;

class GetBridePackageListRequest extends FormRequest
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
        $bridePackegeFilter = new BridePackegeFilter();

        if ($this->filled('order_by')) {
            $bridePackegeFilter->setOrderBy($this->input('order_by'));
        }

        if ($this->filled('order')) {
            $bridePackegeFilter->setOrder($this->input('order'));
        }

        if ($this->filled('per_page')) {
            $bridePackegeFilter->setPerPage($this->input('per_page'));
        }
        return $bridePackegeFilter;
    }
}
