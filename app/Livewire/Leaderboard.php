<?php

namespace App\Livewire;

use Livewire\Component;

class Leaderboard extends Component
{
    public $users = [];

    public function mount()
    {
        $this->users = [
            [
                'id' => '1',
                'username' => 'root',
                'total_score' => 9999,
                'is_admin' => true,
                'avatar_url' => 'https://www.hackthebox.com/storage/avatars/41f4b40705a81e35591c29b7b9f9e8a7.png',
                'created_at' => '2024-01-01T12:00:00Z',
            ],
            [
                'id' => '2',
                'username' => 'admin',
                'total_score' => 9998,
                'is_admin' => true,
                'avatar_url' => 'https://www.hackthebox.com/storage/avatars/41f4b40705a81e35591c29b7b9f9e8a7.png',
                'created_at' => '2024-01-01T12:00:00Z',
            ],
            [
                'id' => '3',
                'username' => 'user',
                'total_score' => 100,
                'is_admin' => false,
                'avatar_url' => 'https://www.hackthebox.com/storage/avatars/41f4b40705a81e35591c29b7b9f9e8a7.png',
                'created_at' => '2024-01-01T12:00:00Z',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.leaderboard');
    }
}
