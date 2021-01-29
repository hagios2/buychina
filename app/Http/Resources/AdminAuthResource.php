<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminAuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [

            'id' => $this->id,

            'name' => $this->name,

            'email' => $this->email,

            'phone' => $this->phone,

            'role' => $this->role,

            'must_change_password' => $this->must_change_password,

            'last_login' => $this->last_login,

            'isActive' => $this->isActive

        ];
    }
}
