<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use \Carbon\Carbon;

class ProductReviewResource extends JsonResource
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

            'rating' => $this->rating,

            'review' => $this->review,

            'user' => [
                
                'id' => $this->user->id,

                'name' => $this->user->name,

                'avatar' => $this->user->avatar

            ],

            'date' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d'),

            'time' =>  Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('H:i'),
        ];
    }
}
