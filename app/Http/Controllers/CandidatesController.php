<?php
namespace App\Http\Controllers;

use App\Models\Candidates;
use Illuminate\Http\Request;

class CandidatesController extends Controller
{
    public function index()
    {
        // Retrieve all candidates from the database
        $candidates = Candidates::all();

        // Return the list of candidates as JSON
        return response()->json($candidates);
    }
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

    public function show($id)
    {
        // Find the candidate by ID, or return a 404 error if not found
        $candidate = Candidates::find($id);

        if (!$candidate) {
            return response()->json(['message' => 'Candidate not found'], 404);
        }

        // Return the candidate data as JSON
        return response()->json($candidate);
    }

    public function update(Request $request, $id)
    {
        // Find the candidate by ID, or return a 404 error if not found
        $candidate = Candidates::find($id);

        if (!$candidate) {
            return response()->json(['message' => 'Candidate not found'], 404);
        }

        // Validate the request input
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'last_position' => 'required|string|max:255',
            'jci_career' => 'required|string',
            'category_id' => 'required|exists:categories,id'
        ]);

        // Update the candidate's details
        $candidate->update($request->all());

        // Return the updated candidate data as JSON
        return response()->json([
            'message' => 'Candidate updated successfully!',
            'candidate' => $candidate
        ]);
    }

    public function destroy($id)
    {
        // Find the candidate by ID
        $candidate = Candidates::find($id);

        // If the candidate is not found, return a 404 error
        if (!$candidate) {
            return response()->json(['message' => 'Candidate not found'], 404);
        }

        // Delete the candidate
        $candidate->delete();

        // Return a success message
        return response()->json(['message' => 'Candidate deleted successfully!']);
    }
}
