<?php

namespace App\Http\Controllers;

use App\Models\CtfEvent;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    public function index(CtfEvent $event)
    {
        // Fetch challenges for this event
        $challenges = $event->challenges()
            ->where('is_active', true)
            ->get();

        // Calculate stats (placeholder logic for now, utilizing DB relations later)
        $totalPoints = $challenges->sum('points');
        // $solvedCount = 0; // TODO: Implement solve counting based on auth user
        $rank = 0; // TODO: Implement leaderboard ranking

        // Group categories for the filter (extract unique categories from challenges)
        $uniqueCategories = $challenges->pluck('category')->unique()->values()->all();
        $categories = array_merge(['All'], $uniqueCategories);
        
        if (count($categories) === 1) { // Only 'All' exists
             $categories = ['All', 'Web', 'Pwn', 'Crypto', 'Forensics', 'Reverse'];
        }

        return view('challenges', [
            'event' => $event,
            'challenges' => $challenges,
            'categories' => $categories,
            'stats' => [
                'total_points' => $totalPoints,
                'solved_percentage' => $totalPoints > 0 ? 0 : 0, // Placeholder
                'rank' => $rank,
            ]
        ]);
    }

    public function submit(Request $request, \App\Models\Challenge $challenge)
    {
        // 1. Validate Request
        $request->validate([
            'flag' => 'required|string',
        ]);

        // 2. Check Auth
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $user = auth()->user();

        // 3. Check if already solved
        $existingSolve = \App\Models\Solve::where('user_id', $user->id)
            ->where('challenge_id', $challenge->id)
            ->exists();

        if ($existingSolve) {
            return response()->json(['message' => 'You have already solved this challenge.', 'status' => 'already_solved'], 400);
        }

        // 4. Validate Flag
        // Hash the submitted flag and compare with stored hash
        $submittedHash = hash('sha256', $request->flag);

        if ($submittedHash === $challenge->flag_hash) {
            // Correct Flag!
            \App\Models\Solve::create([
                'user_id' => $user->id,
                'challenge_id' => $challenge->id,
            ]);

            return response()->json([
                'message' => 'Correct flag! + ' . $challenge->points . ' points',
                'status' => 'success',
                'points' => $challenge->points
            ]);
        } else {
            // Incorrect Flag
            return response()->json(['message' => 'Incorrect flag.', 'status' => 'error'], 400);
        }
    }
}
