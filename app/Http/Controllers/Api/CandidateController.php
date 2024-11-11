<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Candidates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class CandidateController extends Controller
{
    public function index(Request $request)
    {
        Log::info('API routes loaded.'); // Add this line

        $limit = $request->query('limit', null);
        $category_id = $request->query('category_id', null);

        $query = Candidates::latest();



        if ($category_id) {
            $query->where('category_id', $category_id);
        }


        if ($limit && is_numeric($limit)) {
            $query->limit($limit);
        }

        // Retrieve all candidates from the database
        $candidates = $query->get();

        if ($candidates->isEmpty()) {
            return response()->json(['message' => 'No candidates found'], 404);
        }

        // Return the list of candidates as JSON
        return response()->json($candidates);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'last_position' => 'required|string|max:255',
            'jci_career' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'media.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,mp4,avi,mkv,mov|max:102400',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        // $user = User::where('email', $request->email)->first();

        // if (! $user || ! Hash::check($request->password, $user->password)) {
        //     throw ValidationException::withMessages([
        //         'email' => ['The provided credentials are incorrect.'],
        //     ]);
        // }

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
        // Validate the request input
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'last_position' => 'required|string|max:255',
            'jci_career' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'media.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,mp4,avi,mkv,mov|max:102400',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        Log::info('Update method called for candidate ID: ' . $id);
        // Find the candidate by ID, or return a 404 error if not found
        $candidate = Candidates::find($id);

        if (!$candidate) {
            return response()->json(['message' => 'Candidate not found'], 404);
        }
        // Update the candidate's details
        $candidate->update($request->all());
        // Return the updated candidate data as JSON
        return response()->json(['message' => 'Candidate updated successfully!', 'candidate' => $candidate], 201);
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
