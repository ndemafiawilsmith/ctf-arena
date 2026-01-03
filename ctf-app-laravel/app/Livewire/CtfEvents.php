<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CtfEvents extends Component
{
    public $events = [];
    public $leaderboard = [];

    public function mount()
    {
        $this->events = \App\Models\CtfEvent::where('is_active', true)
            ->with(['accesses' => function ($query) {
                $query->where('user_id', Auth::id())->where('status', 'success');
            }])
            ->orderBy('start_time', 'asc')
            ->get();

        $this->leaderboard = \App\Models\User::select('users.id', 'users.name')
            ->join('solves', 'users.id', '=', 'solves.user_id')
            ->join('challenges', 'solves.challenge_id', '=', 'challenges.id')
            ->selectRaw('SUM(challenges.points) as total_points')
            ->selectRaw('COUNT(solves.id) as total_solves')
            ->selectRaw('MAX(solves.created_at) as last_solve_at')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_points')
            ->orderBy('last_solve_at')
            ->limit(10)
            ->get();
    }

    public function render()
    {
        return view('livewire.ctf-events', [
            'events' => $this->events,
        ])->layout('components.layouts.app');
    }
}
