<?php

namespace App\Http\Controllers;


use App\Mail\ShopRegistrationMail;
use App\Merchandiser;
use Illuminate\Http\Request;
use App\Http\Requests\MerchandiserFormRequest;
use App\Http\Requests\UpdateMerchandiserRequest;
use Illuminate\Support\Facades\Hash;
use App\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Jobs\ShopRegistrationJob;

class MerchandiserRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:merchandiser')->only(['update', 'destroy']);
    }

    public function register(MerchandiserFormRequest $request)
    {
        $attributes = $request->validated();

        $attributes['password'] = Hash::make($request->password);

        if($request->has('free_trial') && (int) $request->free_trial == 1)
        {
            $attributes['payment_status'] = 'free';

        }else{
            $attributes['payment_status'] = 'free';
        }

        $merchandiser = Merchandiser::create($attributes);

        $new_token = Str::random(60);

        $token = VerifyEmail::create([
            'token' => $new_token,
            'merchandiser_id' => $merchandiser->id,
            'isAShopToken' => true
        ]);


        //Mail::to($merchandiser)->send(new ShopRegistrationMail($merchandiser, $token));
        ShopRegistrationJob::dispatch($merchandiser, $token);

       /*  $merchandiser->notify(new UserRegistrationNotification());  */

        return response()->json(['status' => 'success', 'merchandiser_id' => $merchandiser->id], 200);
    }


    public function storePhotos(Merchandiser $merchandiser, $file_type)
    {

        if($file_type == 'avatar')
        {
            $file = request()->file('avatar');

        }else if($file_type == 'cover_photo'){

            $file = request()->file('cover_photo');

        }else if($file_type == 'valid_id'){

            $file = request()->file('valid_id');

        }

        $fileName = $file->getClientOriginalName();

        $file->storeAs('public/'.$file_type.'/'.$merchandiser->id, $fileName);

        $merchandiser->update([$file_type => 'storage/'.$file_type.'/'.$merchandiser->id.'/'.$fileName]);
    }

    public function saveAvatarAndCover(Merchandiser $merchandiser, Request $request)
    {
        $request->validate([
            'cover_photo' => 'nullable|image|mimes:png,jpg,jpeg',

            'avatar' => 'nullable|image|mimes:png,jpg,jpeg',

            'valid_id' => 'nullable|image|mimes:png,jpg,jpeg'

        ]);

        if($request->hasFile('cover_photo'))
        {
            $this->storePhotos($merchandiser, 'cover_photo');
        }


        if($request->hasFile('avatar'))
        {
            $this->storePhotos($merchandiser, 'avatar');
        }


        if($request->hasFile('valid_id'))
        {
            $this->storePhotos($merchandiser, 'valid_id');
        }


        return response()->json(['status' => 'saved photos'], 200);

    }


    public function update(Merchandiser $merchandiser, UpdateMerchandiserRequest $request)
    {
        $merchandiser->update($request->validated());

        return response()->json(['status' => 'success'], 200);
    }


    public function destroy()
    {

        $merchandiser = auth()->guard('merchandiser')->user();

        if($merchandiser->product)
        {
            $merchandiser->product->map(function($shopProduct){

                $shopProduct->delete();

            });
        }


        $merchandiser->delete();

        return response()->json(['status' => 'deleted'], 200);
    }
}
