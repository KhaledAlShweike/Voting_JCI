<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\JsonResponse;


class RegisterUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required_without:phone_number|email|max:255',
            'phone_number' => 'required_without:email|string|max:255',
            'password' => 'required|string|min:8|max:255'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password)
        ]);

        event(new Registered($user));

        // Auth::login($user);

        // return redirect(route('dashboard', absolute: false));

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
