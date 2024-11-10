<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Candidates;
use App\Models\Categories;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function showRegister()
    {
        return view('user.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        Auth::login($user);

        return redirect()->route('user.dashboard');
    }

    public function showLogin()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('user.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function dashboard()
    {
        $categories = Categories::all();
        return view('user.dashboard', compact('categories'));
    }

    public function showCandidates(Categories $category)
    {
        $candidates = $category->candidates;
        return view('user.candidates', compact('category', 'candidates'));
    }

    public function vote(Categories $category, Candidates $candidate)
    {
        $existingVote = Vote::where('user_id', Auth::id())->where('candidate_id', $candidate->id)->first();

        if (!$existingVote) {
            Vote::create([
                'user_id' => Auth::id(),
                'candidate_id' => $candidate->id,
            ]);
        }

        return redirect()->back()->with('success', 'Vote cast successfully!');
    }
}

