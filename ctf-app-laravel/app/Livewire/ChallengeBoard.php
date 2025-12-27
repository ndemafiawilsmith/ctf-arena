<?php

namespace App\Livewire;

use Livewire\Component;

class ChallengeBoard extends Component
{
    public $event;
    public $flags = []; // { challenge_id: flag_input }
    public $filter = 'All';

    public $userScore = 0;
    public $activeTab = 'challenges';

    public function mount(\App\Models\CtfEvent $event)
    {
        $this->event = $event;
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function submitFlag($challengeId)
    {
        if (!auth()->check()) {
            $this->dispatch('error', message: 'You must be logged in.');
            return;
        }

        $flag = $this->flags[$challengeId] ?? '';
        if (empty($flag)) return;

        $user = auth()->user();
        $challenge = \App\Models\Challenge::find($challengeId);

        if (!$challenge) return;

        // Check if already solved
        $existingSolve = \App\Models\Solve::where('user_id', $user->id)
            ->where('challenge_id', $challenge->id)
            ->exists();

        if ($existingSolve) {
            $this->dispatch('info', message: 'You have already solved this challenge.');
            return;
        }

        $submittedHash = hash('sha256', $flag);

        if ($submittedHash === $challenge->flag_hash) {
            \App\Models\Solve::create([
                'user_id' => $user->id,
                'challenge_id' => $challenge->id,
            ]);

            $this->dispatch('success', message: "Correct flag! +{$challenge->points} points");
            // Clear input
            $this->flags[$challengeId] = '';
        } else {
            $this->dispatch('error', message: 'Incorrect flag.');
        }
    }

    public function setFilter($category)
    {
        $this->filter = $category;
    }

    public function calculateUserScore()
    {
        if (!auth()->check()) return 0;
        
        return \App\Models\Solve::where('user_id', auth()->id())
            ->join('challenges', 'solves.challenge_id', '=', 'challenges.id')
            ->where('challenges.ctf_event_id', $this->event->id)
            ->sum('challenges.points');
    }

    public function getLeaderboard()
    {
        // Get users who solved challenges in this event
        // Calculate sum of points and max created_at of solves (for tie breaking)
        return \App\Models\User::select('users.id', 'users.name')
            ->join('solves', 'users.id', '=', 'solves.user_id')
            ->join('challenges', 'solves.challenge_id', '=', 'challenges.id')
            ->where('challenges.ctf_event_id', $this->event->id)
            ->selectRaw('SUM(challenges.points) as total_points')
            ->selectRaw('MAX(solves.created_at) as last_solve_at')
            ->groupBy('users.id', 'users.name') // SQLite/MySQL compatible group by
            ->orderByDesc('total_points')
            ->orderBy('last_solve_at')
            ->limit(50)
            ->get();
    }

    public function render()
    {
        // 1. Fetch ALL active challenges for this event once.
        // This is efficient because typically a CTF has < 100 challenges.
        // It avoids running a second query for statistics.
        $allChallenges = $this->event->challenges()
            ->where('is_active', true)
            ->get();

        // 2. Filter challenges based on selection
        $challenges = $allChallenges;
        if ($this->filter !== 'All') {
            $challenges = $allChallenges->where('category', $this->filter);
        }

        // 3. Helper calculations
        $totalPoints = $allChallenges->sum('points');
        $this->userScore = $this->calculateUserScore();
        
        $categories = $allChallenges->pluck('category')->unique()->values()->all();
        $categories = array_merge(['All'], $categories);
        // Default categories if none exist yet, just for UI stability
        if (count($categories) === 1) $categories = ['All', 'Web', 'Pwn', 'Crypto', 'Forensics', 'Reverse'];

        // 4. Get Solved Status for valid user
        $solvedChallengeIds = [];
        if (auth()->check()) {
            $solvedChallengeIds = \App\Models\Solve::where('user_id', auth()->id())
                ->whereIn('challenge_id', $allChallenges->pluck('id'))
                ->pluck('challenge_id')
                ->toArray();
        }

        return view('livewire.challenge-board', [
            'challenges' => $challenges,
            'categories' => $categories,
            'totalPoints' => $totalPoints,
            'solvedChallengeIds' => $solvedChallengeIds,
            'leaderboard' => $this->activeTab === 'leaderboard' ? $this->getLeaderboard() : []
        ])->layout('layouts.challenge', ['title' => $this->event->name . ' - CTF Arena']); 
    }
}
