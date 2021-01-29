<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Merchandiser;
use App\Http\Resources\FollowersResource;

class FollowersController extends Controller
{
    
    public function __construct()
    {

        $this->middleware('auth:api,merchandiser');

    }


    public function followShop(Merchandiser $shop)
    {

        $following = auth()->guard('api')->user()->following->where('merchandiser_id', $shop->id)->first();

        if($following)
        {
            return response()->json(['status' => 'already following shop']);
        }

        auth()->guard('api')->user()->addFollowing(['merchandiser_id' => $shop->id]); 



        return response()->json(['status' => 'success', 'shop_followers' => $shop->followers->count()]);

    }


    public function unFollowShop(Merchandiser $shop)
    {
        
        auth()->guard('api')->user()->following->where('merchandiser_id', $shop->id)->first()->delete();


        return response()->json(['status' => 'deleted', 'shop_followers' => $shop->followers->count()]);

    }


    public function fetchfollowingShops()
    {
        $following = auth()->guard('api')->user()->following;


        return FollowersResource::collection($following);

    }


}
