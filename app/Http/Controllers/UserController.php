<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function register(Request $request)
    {

        //Validated Request
        //
        //TO:DO

        User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone_number' => $request->input('phone_number'),
            'password' => Hash::make($request->input('password'))
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

    public function login(Request $request)
    {
        if (!$token = auth()->attempt($request->only('phone_number', 'password'))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'token' => $token
            ]
        ]);
    }
}
