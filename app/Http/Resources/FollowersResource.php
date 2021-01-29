<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FollowersResource extends JsonResource
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

            'shop_id' => $this->merchandiser_id,

            'shop_name' => $this->shop->company_name,

            'company_description' => $this->shop->company_description,

            'number_of_followers' =>  $this->shop->followers->count(),

            'campus' => [

                'id' => $this->shop->campus->id,

                'campus' => $this->shop->campus->campus
            ]
        ];
    }
}
