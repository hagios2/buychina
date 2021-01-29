<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Product extends Model implements Searchable
{
    protected $guarded = ['id'];

    public function getSearchResult(): SearchResult
    {
       $url = route('product.details', $this->id);

        $data = [
            'product_images' => $this->image,
            'avg_rating' => $this->review->avg('rating')
        ];

        return new SearchResult(
            $this,
            json_encode($data),
            $url
        );
    }


    public function image()
    {
        return $this->hasMany('App\ProductImage');
    }


    public function addProductImage($image)
    {
        $this->image()->create($image);
    }


    public function category()
    {
        return $this->belongsTo('App\Category');
    }


    public function user()
    {
        return $this->belongsTo('App\User');
    }



    public function merchandiser()
    {
        return $this->belongsTo('App\Merchandiser');
    }


    public function review()
    {
        return $this->hasMany('App\ProductReview');
    }


    public function productReport()
    {
        return $this->hasMany('App\ProductReport');
    }

    public function paidProduct()
    {
        return $this->hasOne(PaidProduct::class);
    }


    public function addPaidProduct($paid_product)
    {
        $this->paidProduct()->create($paid_product);
    }


}
