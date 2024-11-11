<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Candidates;
use Illuminate\Http\Request;


class CandidateMediaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'last_position' => 'required|string|max:255',
            'jci_career' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Images up to 2 MB each
            'video' => 'mimetypes:video/mp4|max:20480', // Video file size up to 20 MB
        ]);

        // Create Candidate
        $candidate = Candidates::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'position' => $request->position,
            'last_position' => $request->last_position,
            'jci_career' => $request->jci_career,
            'category_id' => $request->category_id,
        ]);

        // Save Images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('images', 'public');
                $candidate->images()->create(['image_path' => $imagePath]);
            }
        }

        // Save Video
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoPath = $video->store('videos', 'public');
            $candidate->video()->create(['video_path' => $videoPath]);
        }

        return response()->json(['success' => 'Candidate profile created successfully']);
    }
}
