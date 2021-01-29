<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ViewAdminsResource extends JsonResource
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

            'isActive' => $this->isActive,

            'last_login' => $this->last_login
        ];
    }
}
