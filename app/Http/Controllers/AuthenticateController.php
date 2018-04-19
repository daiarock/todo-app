<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;

class AuthenticateController extends Controller
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        } 

        $user = User::where('email', $request->email)->first();

        // all good so return the token
        return response()->json(compact('user', 'token'));

        // $credentials = $request->only('email', 'password');

        // $validator = Validator::make($credentials, [
        //     'email' => 'required|email',
        //     'password' => 'required'
        // ]);

        // if ($validator->fails()) {
        //     return response()
        //         ->json([
        //             'code' => 1,
        //             'message' => 'Validation failed.',
        //             'errors' => $validator->errors()
        //         ], 422);
        // }

        // $token = JWTAuth::attempt($credentials);

        // if ($token) {
        //     return response()->json(['token' => $token]);
        // } else {
        //     return response()->json(['code' => 2, 'message' => 'Invalid credentials.'], 401);
        // }
    }

    // /**
    //  * Get the user by token.
    //  *
    //  * @param  Request  $request
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function getUser(Request $request)
    // {
    //     JWTAuth::setToken($request->input('token'));
    //     $user = JWTAuth::toUser();
    //     return response()->json($user);
    // }

    public function getCurrentUser()
    {
        $user = JWTAuth::parseToken()->authenticate();
        return response()->json(compact('user'));
    }

    public function logout()
    {
    }
}