<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\AdminAuthResource;
use Admin;

class AuthController extends Controller
{
        /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        
        $credentials = request(['email', 'password']);

        $credentials['isActive'] = true;

        if (! $token = auth()->guard('admin')->attempt($credentials)) {

            return response()->json(['error' => 'Unauthorized'], 401);
        }

     /*    Admin::where('email', request()->email) */
        auth()->guard('admin')->user()->update(['last_login', now()]);

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthUser()
    {
        return new AdminAuthResource(auth()->guard('admin')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->guard('admin')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->guard('admin')->refresh());
    }

      /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 3600,
            'statusCode' => 200
        ]);
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

                'isAdminEmail' => true
            ]);

            //Mail::to($client)->send(new ClientPasswordResetMail($client, $token));
            ShopPasswordResetJob::dispatch($shop, $token);

            return response()->json(['status' => 'Email sent']);
        }

        return response()->json(['status' => 'Email not found'], 404);
    }

    
}
