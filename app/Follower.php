<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    
    protected $fillable = ['user_id', 'merchandiser_id'];


    public function user()
    {

        return $this->belongsTo('App\User');

    }



    public function shop()
    {

        return $this->belongsTo('App\Merchandiser', 'merchandiser_id');
        
    }
}
