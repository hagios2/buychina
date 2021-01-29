<?php

namespace App\Http\Resources;

use App\ProductImage;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       // return parent::toArray($request);

       return [


            $this->collection->map(function($product){

                return  [

                    'id' => $product->id,

                    'product_name' => $product->product_name,

                    'price' => $product->price,

                    'in_stock' => $product->in_stock,

                    'product_description' => $product->description,

                    'product_image' => ProductImage::where('product_id', $product->id)->latest()->take(1)->get('path')

               ];
                //$product->image->reverse()->take(1)];

            }),

       ];
    }
}
