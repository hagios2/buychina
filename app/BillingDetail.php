<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingDetail extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function merchandiser()
    {
        return $this->belongsTo(Merchandiser::class);
    }
}
