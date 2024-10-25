<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
// use Inertia\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;


class LoginController extends Controller
{


    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

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

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
