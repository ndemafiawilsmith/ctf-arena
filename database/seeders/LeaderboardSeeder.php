<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Challenge;
use App\Models\Solve;
use Illuminate\Support\Facades\Hash;

class LeaderboardSeeder extends Seeder
{
    public function run(): void
    {
        // Create 10 dummy users
        $users = User::factory(10)->create();

        // Get all challenges
        $challenges = Challenge::all();

        if ($challenges->isEmpty()) {
            return;
        }

        // Randomly assign solves
        foreach ($users as $user) {
            // Each user solves 0-5 challenges
            $solvesCount = rand(0, 5);
            $solvedChallenges = $challenges->random(min($solvesCount, $challenges->count()));

            foreach ($solvedChallenges as $challenge) {
                // Check uniqueness just in case
                if (!Solve::where('user_id', $user->id)->where('challenge_id', $challenge->id)->exists()) {
                    Solve::create([
                        'user_id' => $user->id,
                        'challenge_id' => $challenge->id,
                        'created_at' => now()->subMinutes(rand(1, 1000)), // vary time for tie-breaking
                    ]);
                }
            }
        }
    }
}
