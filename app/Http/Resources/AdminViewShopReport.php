<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminViewShopReport extends JsonResource
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

            'report' => $this->report,

            'user' => [

                'id' => $this->user_id,

                'name' => $this->user->name,

                'email' => $this->user->email
            ],

            'shop' => [
                
               'id' => $this->merchandiser_id,

               'shop_name' => $this->shop->company_name
            ]

        ];
    }
}
