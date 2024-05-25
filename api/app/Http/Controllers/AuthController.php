<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;



class AuthController extends Controller
{

    public function login()
    {
        $credentials = request(['email', 'password']);
        $token = auth()->attempt($credentials);
        if($token === false){
            return response()->json(['error' => 'Login ou Senha incorretos'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
