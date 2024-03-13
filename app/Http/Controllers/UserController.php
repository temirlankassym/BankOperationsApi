<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function register(UserStoreRequest $request)
    {
        User::create($request->validated());

        return response()->json([
            'success' => true,
        ]);
    }

    public function login(LoginRequest $request)
    {
        if (!$token = auth()->attempt($request->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'token' => $token
            ]
        ]);
    }

    public function show(){
        return response()->json([
            'User' => new UserResource(auth()->user())
        ]);
    }

    public function logout(){
        auth()->logout();
        return response()->json([
            'Success'
        ],204);
    }
}
