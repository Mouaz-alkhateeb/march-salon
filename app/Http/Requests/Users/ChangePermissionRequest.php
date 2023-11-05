<?php

namespace App\Http\Requests\Users;

use App\Statuses\HavePermission;
use App\Statuses\PermissionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangePermissionRequest extends FormRequest
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
            'type' => ['required', Rule::in(PermissionType::$statuses)],
            'can' => ['required', Rule::in(HavePermission::$statuses)]
        ];
    }
}