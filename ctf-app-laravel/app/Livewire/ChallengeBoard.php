<?php

namespace App\Livewire;

use Livewire\Component;

class ChallengeBoard extends Component
{
    public $challenges = [];

    public function mount()
    {
        $this->challenges = [
            [
                'id' => '1',
                'event_id' => '1',
                'title' => 'Web Challenge 1',
                'description' => 'A web challenge that requires you to find a vulnerability in a web application and exploit it to get the flag.',
                'category' => 'Web',
                'points' => 100,
                'difficulty' => 'easy',
                'external_link' => 'https://example.com/challenge1',
                'flag_hash' => 'flag{this_is_a_fake_flag}',
                'hints' => ['Hint 1', 'Hint 2'],
                'is_active' => true,
                'created_at' => '2024-12-15T12:00:00Z',
            ],
            [
                'id' => '2',
                'event_id' => '1',
                'title' => 'Pwn Challenge 1',
                'description' => 'A pwn challenge that requires you to reverse engineer a binary and find a vulnerability to get a shell.',
                'category' => 'Pwn',
                'points' => 200,
                'difficulty' => 'medium',
                'external_link' => 'https://example.com/challenge2',
                'flag_hash' => 'flag{this_is_another_fake_flag}',
                'hints' => ['Hint 1', 'Hint 2'],
                'is_active' => true,
                'created_at' => '2024-12-15T12:00:00Z',
            ],
            [
                'id' => '3',
                'event_id' => '1',
                'title' => 'Crypto Challenge 1',
                'description' => 'A crypto challenge that requires you to break a cipher and decrypt a message to get the flag.',
                'category' => 'Crypto',
                'points' => 300,
                'difficulty' => 'hard',
                'external_link' => 'https://example.com/challenge3',
                'flag_hash' => 'flag{this_is_a_third_fake_flag}',
                'hints' => ['Hint 1', 'Hint 2'],
                'is_active' => true,
                'created_at' => '2024-12-15T12:00:00Z',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.challenge-board');
    }
}
