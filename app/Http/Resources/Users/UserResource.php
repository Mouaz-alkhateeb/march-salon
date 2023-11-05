<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'type' => $this->type,
            'permission_to_delay' => $this->permission_to_delay,
            'permission_to_cancle' => $this->permission_to_delete,
            'permission_to_update' => $this->permission_to_update,
        ];
    }
}
