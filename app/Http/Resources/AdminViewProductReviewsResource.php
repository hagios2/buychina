<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use \Carbon\Carbon;

class AdminViewProductReviewsResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function($review){
        
            return  [

                'id' => $review->id,

                'rating' => $review->rating,
    
                'review' => $review->review,
    
                'user' => [
                    
                    'id' => $review->user->id,
    
                    'name' => $review->user->name,
    
                    'avatar' => $review->user->avatar
    
                ],
    
                'date' => Carbon::createFromFormat('Y-m-d H:i:s', $review->created_at)->format('Y-m-d'),
    
                'time' =>  Carbon::createFromFormat('Y-m-d H:i:s', $review->created_at)->format('H:i'),
            ];
        });
    }
}
