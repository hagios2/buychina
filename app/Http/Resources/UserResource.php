<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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

            'campus' => [

                'id' => $this->campus->id,

                'campus' => $this->campus->campus
            ],

            'valid_id' => $this->valid_id,

            'qualified_for_free_trial' => $this->qualified_for_free_trial

        ];
    }
}
