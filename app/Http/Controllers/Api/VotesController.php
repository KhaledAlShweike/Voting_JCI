<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Candidates;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class VotesController extends Controller
{

    public function vote(Request $request, $candidateId): JsonResponse
    {
        // Validate the request
        $validated = $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        $user = $request->user();

        // Find the candidate and check if the candidate is active
        $candidate = Candidates::where('id', $candidateId)
            ->where('is_active', true)
            ->firstOrFail();
        $categoryId = $candidate->category_id;

        // Use a transaction to ensure atomicity and concurrency control
        DB::transaction(function () use ($user, $candidateId, $categoryId) {
            // Lock the user's existing votes for the category
            $existingVote = Vote::where('user_id', $user->id)
                ->where('category_id', $categoryId)
                ->lockForUpdate()
                ->first();

            // Update the vote if it exists, otherwise create a new one
            Vote::updateOrCreate(
                ['user_id' => $user->id, 'category_id' => $categoryId],
                ['candidate_id' => $candidateId]
            );
        });

        return response()->json(['message' => 'Vote successfully cast!'], 200);
    }
}
