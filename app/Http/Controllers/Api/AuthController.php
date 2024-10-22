<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required_without:phone_number|email|max:255',
            'phone_number' => 'required_without:email|string|max:255',
            'password' => 'required|string|min:8|max:255'
        ]);

        $user = User::where('email', $request->email)
            ->orWhere('phone_number', $request->phone_number)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'The provided credentials are incorrect'], 401);
        }

        $token = $user->createToken($user->name . 'Auth-Token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token_type' => 'Bearer',
            'token' => $token
        ], 200);
    }

    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required_without:phone_number|email|unique:users,email|max:255',
            'phone_number' => 'required_without:email|string|unique:users,phone_number|max:255',
            'password' => 'required|string|min:8|max:255'
        ]);

        Log::info('Before :', $request->toArray());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password)
        ]);

        Log::info('Before :', $request->toArray());

        if ($user) {
            $token = $user->createToken($user->name . 'Auth-Token')->plainTextToken;

            return response()->json([
                'message' => 'Registration successful',
                'user' => $user,
                'token_type' => 'Bearer',
                'token' => $token
            ], 201);
        } else {
            return response()->json([
                'message' => 'Something Went wrong! while registration'
            ], 500);
        }
    }
}
