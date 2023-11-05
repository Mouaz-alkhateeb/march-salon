<?php

namespace App\Http\Requests\Receiption;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReceiptionRequest extends FormRequest
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
            'receiption_id' => 'required|exists:users,id',
            'name' => 'nullable',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'nullable'
        ];
    }
}
