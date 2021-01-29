<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReport extends Model
{
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
