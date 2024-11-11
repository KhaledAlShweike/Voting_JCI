<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidates;
use App\Models\Categories;

use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to be logged in to access the admin dashboard.');
        }

        // Retrieve data for the dashboard
        $topVotedCandidates = Candidates::orderBy('votes', 'desc')->take(5)->get();
        $projectsPerCategory = Categories::withCount('projects')->get();
        $totalUsers = User::count();

        // Pass data to the dashboard view
        return view('admin.dashboard', [
            'topVotedCandidates' => $topVotedCandidates,
            'projectsPerCategory' => $projectsPerCategory,
            'totalUsers' => $totalUsers
        ]);
    }

    /**
     * Handle admin login functionality (if custom logic is needed).
     */
    public function login(Request $request)
    {
        // Custom logic for admin login if necessary
        $request->validate([
            'code' => 'required',
        ]);

        // For example, validate admin login code here (use your logic)
        if ($request->code == 'your_admin_code') {
            Auth::loginUsingId(1); // Replace with actual admin user ID
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'code' => 'The provided code is incorrect.',
        ]);
    }
}
