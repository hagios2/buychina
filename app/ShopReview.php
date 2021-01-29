<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopReview extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function shop()
    {
        return $this->belongsTo('App\Merchandiser');
    }

}
