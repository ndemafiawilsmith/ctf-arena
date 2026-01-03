<?php

namespace App\Livewire;

use App\Models\CtfEvent as CtfEventModel;
use App\Models\Challenge;
use App\Models\Solve;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CtfEvent extends Component
{
    public CtfEventModel $event;
    public $flag = [];
    public $successMessage = '';
    public $errorMessage = '';

    public function mount(CtfEventModel $event)
    {
        $this->event = $event;
        $this->event->load('challenges'); // Eager load challenges
    }

    public function submitFlag($challengeId)
    {
        $this->successMessage = '';
        $this->errorMessage = '';

        if (!Auth::check()) {
            $this->errorMessage = 'You must be logged in to submit a flag.';
            return;
        }

        $challenge = Challenge::findOrFail($challengeId);
        $submittedFlag = $this->flag[$challengeId] ?? '';

        // Hash the submitted flag for comparison
        $submittedFlagHash = hash('sha256', $submittedFlag);

        if ($submittedFlagHash === $challenge->flag_hash) {
            // Check if user already solved this challenge
            $alreadySolved = Solve::where('user_id', Auth::id())
                                  ->where('challenge_id', $challengeId)
                                  ->exists();

            if (!$alreadySolved) {
                Solve::create([
                    'user_id' => Auth::id(),
                    'challenge_id' => $challengeId,
                ]);
                $this->successMessage = 'Correct flag! You solved the challenge.';
            } else {
                $this->errorMessage = 'You have already solved this challenge.';
            }
        } else {
            $this->errorMessage = 'Incorrect flag. Please try again.';
        }

        // Clear the input field
        if (isset($this->flag[$challengeId])) {
            $this->flag[$challengeId] = '';
        }
    }

    public function render()
    {
        // Get the IDs of challenges solved by the current user for this event
        $solvedChallengeIds = [];
        if(Auth::check()){
            $solvedChallengeIds = Solve::where('user_id', Auth::id())
            ->whereIn('challenge_id', $this->event->challenges->pluck('id'))
            ->pluck('challenge_id')
            ->toArray();
        }

        return view('livewire.ctf-event', [
            'solvedChallengeIds' => $solvedChallengeIds
        ])->layout('components.layouts.app');
    }
}
