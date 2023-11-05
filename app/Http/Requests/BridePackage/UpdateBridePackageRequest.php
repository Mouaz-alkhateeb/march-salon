<?php

namespace App\Http\Requests\BridePackage;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBridePackageRequest extends FormRequest
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
            'bride_package_id' => 'required|exists:bride_packages,id',
            'name' => 'nullable'
        ];
    }
}
