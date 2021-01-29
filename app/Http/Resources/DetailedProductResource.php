<?php

namespace App\Http\Resources;

use App\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $productOwner = [];

        if($this->merchandiser)
        {
            $productOwner['merchandiser_id'] = $this->merchandiser->id;

            $productOwner['company_name'] = $this->merchandiser->company_name;

            $productOwner['avatar'] = $this->merchandiser->avatar;

            $productOwner['email'] = $this->merchandiser->email;

            $productOwner['campus'] = [

                'id' => $this->merchandiser->campus->id,

                'campus' => $this->merchandiser->campus->campus,

            ];

            $productOwner['phone'] = $this->merchandiser->phone;


        }else if($this->user){

            $productOwner['user_id'] = $this->user->id;

            $productOwner['name'] = $this->user->name;

            $productOwner['avatar'] = $this->user->avatar;

            $productOwner['email'] = $this->user->email;

            $productOwner['campus'] = [

                'id' => $this->user->campus->id,

                'campus' => $this->user->campus->campus,

            ];

            $productOwner['phone'] = $this->user->phone;
        }

        $product = Product::find($this->id);

       return [

                'id' => $this->id,

                'product_name' => $this->product_name,

                'price' => $this->price,

                'in_stock' => $this->in_stock, #subtract from puchased from this

                'description' =>  $this->description,

                'product_owner' => $productOwner,

                'product_images' => ProductImageResource::collection($this->image), //path

                'related_product' => RelatedProductResource::collection($this->relatedItems($product))

       ];
    }

    public function relatedItems(Product $product)
    {
        $products = Product::where([['id', '!=', $product->id],['category_id', $product->category_id]])->latest()->take(5)->get();

        return $products;
    }
}
