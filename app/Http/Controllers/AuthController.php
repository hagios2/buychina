<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\UserResource;

class AuthController extends Controller
{
      /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
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

        if (! $token = auth()->attempt($credentials)) {

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

        return new UserResource(auth()->user());

    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {

        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
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


    public function saveValidId(Request $request)
    {
        $request->validate(['valid_id' => 'nullable|image|mimes:png,jpg,jpeg']);

        $file = $request->file('valid_id');

        $user = auth()->guard('api')->user();

        $fileName = $file->getClientOriginalName();

        $path = "public/valid ids/$user->id/";

        $file->storeAs($path, $fileName);

        $user->update(['valid_id' => $path.$fileName]);

        return response()->json(['status' => 'File saved']);
    }
    
}
