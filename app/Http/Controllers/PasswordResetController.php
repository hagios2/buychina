<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Merchandiser;
use App\ApiPasswordReset;
use App\Jobs\PasswordResetJob;
use App\Jobs\ShopPasswordResetJob;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangePasswordRequest;

class PasswordResetController extends Controller
{
    public function __construct()
    {
      
        $this->middleware('auth:api,merchandiser', ['only' => ['changeUserPassword', 'changeMediaPassword']]);
        
    }

    public function changeUserPassword(ChangePasswordRequest $request)
    {
        $client = auth()->guard('api')->user();

        if(Hash::check($request->password, $client->password))
        {
            if($request->password == $request->new_password)
            {
                return response()->json(['status' => 'Password is already in use']);

            }else{

                $client->update(['password' => Hash::make($request->new_password)]);

                return response()->json(['status' => 'password changed']);
            }

        }

        return response()->json(['status' => 'invalid Password']);
    }


    public function changeShopPassword(ChangePasswordRequest $request)
    {
        $shop = auth()->guard('merchandiser')->user();

        if(Hash::check($request->password, $shop->password))
        {
            if($request->password == $request->new_password)
            {
                return response()->json(['status' => 'Password is already in use']);

            }else{

                $shop->update(['password' => Hash::make($request->new_password)]);

                return response()->json(['status' => 'password changed']);
            }

        }

        return response()->json(['status' => 'invalid Password']);
    }
    
    
    public function sendResetMail(Request $request)
    {

        $request->validate(['email' => 'required|email']);

        $client = User::where('email', $request->email)->first();

        if($client)
        {
            $gen_token = Str::random(70);

            $token = ApiPasswordReset::create([
                'email' => $client->email,

                'token' => $gen_token,

                'isUserEmail' => true
            ]);

            //Mail::to($client)->send(new ClientPasswordResetMail($client, $token));
            PasswordResetJob::dispatch($client, $token);

            return response()->json(['status' => 'Email sent']);
        }

        return response()->json(['status' => 'Email not found'], 404);
    }


    public function sendShopResetMail(Request $request)
    {

        $request->validate(['email' => 'required|email']);

        $shop = Merchandiser::where('email', $request->email)->first();

        if($shop)
        {
            $gen_token = Str::random(70);

            $token = ApiPasswordReset::create([

                'email' => $shop->email,

                'token' => $gen_token,

                'isMediaEmail' => true
            ]);

            //Mail::to($client)->send(new ClientPasswordResetMail($client, $token));
            ShopPasswordResetJob::dispatch($shop, $token);

            return response()->json(['status' => 'Email sent']);
        }

        return response()->json(['status' => 'Email not found'], 404);
    }



    public function reset(Request $request)
    {
        $token = ApiPasswordReset::where([['token', $request->token], ['isUserEmail', true]])->first();

        if($token)
        {

            if(!$token->hasExpired)
            {
                $client = User::where('email', $token->email)->first();

                $client->update(['password' => Hash::make($request->password)]);

                $token->update(['hasExpired' => true]);

                return response()->json(['status' => 'new password saved']);
            }
           
            return response()->json(['status' => 'Operation Aborted! Token has Expired'], 403);
        }

        return response()->json(['status' => 'Token not found']);
    }



    public function shopReset(Request $request)
    {
        $token = ApiPasswordReset::where([['token', $request->token], ['isMediaEmail', true]])->first();

        if($token)
        {

            if(!$token->hasExpired)
            {
                $shop = Merchandiser::where('email', $token->email)->first();

                $shop->update(['password' => Hash::make($request->password)]);

                $token->update(['hasExpired' => true]);

                return response()->json(['status' => 'new password saved']);
            }
           
            return response()->json(['status' => 'Operation Aborted! Token has Expired'], 403);
        }

        return response()->json(['status' => 'Token not found']);
    }
}
