<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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




     /*-----------------------------                                  -----------*/

     public function showLoginForm()
     {
         return view('admin.login');
     }



     /*-----------------------------                                  -----------*/


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



     /*-----------------------------                                  -----------*/


     public function dashboard()
{
    $categories = Categories::with(['candidates' => function ($query) {
        $query->orderBy('votes', 'desc')->limit(1); // Assuming a 'votes' column exists
    }])->get();

    return view('admin.dashboard', compact('categories'));
}



/*-----------------------------                                  -----------*/

public function showCategory($id)
{
    $category = Categories::with('candidates')->findOrFail($id);
    return view('admin.category', compact('category'));
}



/*-----------------------------                                  -----------*/


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



/*-----------------------------                                  -----------*/
public function index()
{
    $candidates = Candidates::all();

    return response()->json($candidates);
}


/*-----------------------------                                  -----------*/

public function store(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'position' => 'required|string|max:255',
        'last_position' => 'required|string|max:255',
        'jci_career' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'media.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,mp4,avi,mkv,mov|max:102400',
    ]);

    $candidate = Candidates::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'position' => $request->position,
        'last_position' => $request->last_position,
        'jci_career' => $request->jci_career,
        'category_id' => $request->category_id,
    ]);

    if ($request->hasFile('media')) {
        foreach ($request->file('media') as $file) {
            $type = in_array($file->getClientOriginalExtension(), ['mp4', 'avi', 'mkv', 'mov']) ? 'video' : 'image';

            $filePath = $file->store('uploads', 'public');

            $candidate->media()->create([
                'file_path' => $filePath,
                'type' => $type,
            ]);
        }
    }


    return response()->json(['message' => 'Candidate created successfully!', 'candidate' => $candidate], 201);
}



/*-----------------------------                                  -----------*/


public function show($id)
{
    $candidate = Candidates::find($id);

    if (!$candidate) {
        return response()->json(['message' => 'Candidate not found'], 404);
    }

    return response()->json($candidate);
}



/*-----------------------------                                  -----------*/

public function update(Request $request, $id)
{
    $candidate = Candidates::find($id);

    if (!$candidate) {
        return response()->json(['message' => 'Candidate not found'], 404);
    }

    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'position' => 'required|string|max:255',
        'last_position' => 'required|string|max:255',
        'jci_career' => 'required|string',
        'category_id' => 'required|exists:categories,id'
    ]);

    $candidate->update($request->all());

    return response()->json([
        'message' => 'Candidate updated successfully!',
        'candidate' => $candidate
    ]);
}



/*-----------------------------                                  -----------*/

public function destroy($id)
{
    $candidate = Candidates::find($id);

    if (!$candidate) {
        return response()->json(['message' => 'Candidate not found'], 404);
    }

    $candidate->delete();

    return response()->json(['message' => 'Candidate deleted successfully!']);
}
}
