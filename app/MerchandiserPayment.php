<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchandiserPayment extends Model
{
    protected $guarded = ['id'];

    public function shop()
    {
        return $this->belongsTo(Merchandiser::class);
    }
}
