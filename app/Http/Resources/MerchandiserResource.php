<?php

namespace App\Http\Resources;

use App\ShopReview;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchandiserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $avg_rating = ShopReview::where('merchandiser_id', $this->id)->avg('rating');

        return [

            'id' => $this->id,

            'company_name' => $this->company_name,

            'email' => $this->email,

            'company_description' => $this->company_description,

            'avatar' => $this->avatar,

            'cover_photo' => $this->cover_photo,

            'shop_type' => $this->shopType->shop_type,

            'campus' => $this->campus->campus,

            'phone' => $this->phone,

            'valid_id' => $this->valid_id,

            'avg_rating' => $avg_rating,

            'payment_status' => $this->payment_status,

            'no_followers' => $this->followers->count()
        ];
    }
}
