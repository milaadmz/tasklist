<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
//    login with laravel passport
    public function login(LoginRequest $request)
    {
//        login with laravel passport
        if (!$request->validated()) {
            return response('something happened', 422);
        } else {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    $response = ['token' => $token];
                    return response($response, 200);
                } else {
                    $response = ["message" => "Password mismatch"];
                    return response($response, 422);
                }
            } else {
                $response = ["message" => 'User does not exist'];
                return response($response, 422);
            }
        }


    }

//    register with laravel passport
    public function register(RegisterRequest $request)
    {

        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $accessToken = $user->createToken('authToken')->accessToken;
        return response()->json([
            'user' => $user,
            'access_token' => $accessToken
        ]);
    }

// logout with laravel passport
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }


}
