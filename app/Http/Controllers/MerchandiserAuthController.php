<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\MerchandiserResource;

class MerchandiserAuthController extends Controller
{
        /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:merchandiser', ['except' => ['login']]);
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

        if (! $token = auth()->guard('merchandiser')->attempt($credentials)) {

            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthUser()
    {
        return new MerchandiserResource(auth()->guard('merchandiser')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->guard('merchandiser')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->guard('merchandiser')->refresh());
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


    public function toggleToFreeTrial()
    {
        auth()->guard('merchandiser')->user()->update(['payment_status' => 'free', 'qualified_for_free_trial' => now()]);

        return response()->json(['message' => 'free trial activated']);
    }

}
