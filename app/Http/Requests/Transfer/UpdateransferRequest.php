<?php

namespace App\Http\Requests\Transfer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateransferRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'transfer_id' => 'required',
            'date' => 'sometimes',
            'transfer_amount' => 'sometimes',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ];
    }
}
