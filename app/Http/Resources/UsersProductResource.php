<?php

namespace App\Http\Resources;

use App\ProductImage;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersProductResource extends JsonResource
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

            'product_name' => $this->product_name,

            'price' => $this->price,

            'in_stock' => $this->in_stock,

            'product_description' => $this->description,

            'in_cart' => false,

            'payment_status' => $this->payment_status,

            'product_image' => ProductImage::where('product_id', $this->id)->latest()->take(1)->get('path')
        ];
    }
}
