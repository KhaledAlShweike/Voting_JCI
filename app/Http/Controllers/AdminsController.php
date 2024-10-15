<?php

namespace App\Http\Controllers;
use App\Models\Candidates;
use illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Admins;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Candidate;
use App\Models\Categories;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function showLoginForm()
     {
         return view('admin.login');
     }

     public function login(Request $request)
     {
         $request->validate([
             'code' => 'required',
         ]);

         // Check if the admin code exists
         $admin = Admins::where('code', $request->code)->first();

         if ($admin) {
             // Log in the admin manually
             Auth::login($admin);

             // Redirect to the admin dashboard
             return redirect()->route('admin.dashboard');
         }

         return redirect()->back()->withErrors(['code' => 'Invalid admin code.']);
     }

     public function dashboard()
{
    $categories = Categories::with(['candidates' => function ($query) {
        $query->orderBy('votes', 'desc')->limit(1); // Assuming a 'votes' column exists
    }])->get();

    return view('admin.dashboard', compact('categories'));
}

public function showCategory($id)
{
    $category = Categories::with('candidates')->findOrFail($id);
    return view('admin.category', compact('category'));
}

public function storeCandidate(Request $request)
{
    $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'position' => 'required',
        'category_id' => 'required|exists:categories,id',
    ]);

    Candidates::create($request->all());

    return redirect()->route('admin.category.show', $request->category_id)->with('success', 'Candidate created successfully');
}
     public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admins $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admins $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admins $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admins $admin)
    {
        //
    }
}
