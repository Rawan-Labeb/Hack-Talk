<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(RegisterRequest $request){

        $user = User::create($request->validated());

        $token = $user->createToken($user->name.$user->email)->plainTextToken;

        return apiResponse(1, 'User Registered Successfully', [
            'user_date' => $user,
            'access_token' => $token
        ]);
    }

    public function login(LoginRequest $request){

        if(!auth()->attempt($request->only(['email','password']), $request->remember)){
            return apiResponse(0, 'Invalid Credentials');
        }

        $user = auth()->user();
        $token = $user->createToken($user->name.$user->email)->plainTextToken;

        return apiResponse(1, 'Valid Credentials', [
            'user_date' => $user,
            'access_token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return apiResponse(1, 'Logged out successfully');
    }

}
