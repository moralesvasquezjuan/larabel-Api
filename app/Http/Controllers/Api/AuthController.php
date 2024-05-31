<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request-> name,
            'email' => $request-> email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);

    }

    public function login(Request $request){
        if (!Auth::attempt($request->only('email', 'password'))){
            return respose()->json(['message' => 'invalid login details'], 401);
        }
        $user = User::Where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return resposen(-json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]));

    }

    public function userProfile(Request $request){

    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delate();

        return response()->json(['messange' => 'Successfully logged ud']);

    }

    public function allUsers(){

    }
}
