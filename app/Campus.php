<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{

    protected $fillable = ['campus'];


    public function merchandiser()
    {
        return $this->hasMany('App\Merchandiser');
    }


    public function users()
    {
        return $this->hasMany('App\user');
    }


    public function addCarouselImage($image)
    {
        $this->carousel()->create($image);   
    }


    public function carousel()
    {
        return $this->hasMany('App\CarouselControl', 'campus_id');
    }
}
