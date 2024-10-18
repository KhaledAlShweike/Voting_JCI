<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Candidates;
use App\Models\Vote;
use App\Models\Votes;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VotesController extends Controller
{

    public function vote(Request $request, $candidateId): JsonResponse
    {
        $user = $request->user();

        $candidate = Candidates::findOrFail($candidateId);
        $categoryId = $candidate->category_id;

        $existingVote = Votes::where('user_id', $user->id)
            ->where('category_id', $categoryId)
            ->first();

        if ($existingVote) {
            return response()->json(['message' => 'You have already voted for a candidate in this category.'], 403);
        }

        Votes::create([
            'user_id' => $user->id,
            'candidate_id' => $candidateId,
            'category_id' => $categoryId
        ]);

        return response()->json(['message' => 'Vote successfully cast!'], 200);
    }
}
