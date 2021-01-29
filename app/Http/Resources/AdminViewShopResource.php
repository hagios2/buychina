<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminViewShopResource extends JsonResource
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

                'company_name' => $this->company_name,

                /* 'company_description' => $this->company_description,

                'avatar' => $this->avatar,

                'number_of_followers' => $this->followers->count(), */

                'campus' => $this->campus,

                'isActive' => $this->isActive
            ];
       
    }
}
