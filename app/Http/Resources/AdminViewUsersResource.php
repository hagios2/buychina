<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminViewUsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
    
        return  [

            'id' => $this->id,

            'name' => $this->name,

            'email' => $this->email,

            'phone' => $this->phone,

            'campus' => $this->campus,

            'isActive' => $this->isActive
            
        ];
        
    }
}
