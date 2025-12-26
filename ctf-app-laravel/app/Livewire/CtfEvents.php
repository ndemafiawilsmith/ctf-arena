<?php

namespace App\Livewire;

use Livewire\Component;

class CtfEvents extends Component
{
    public $events = [];

    public function mount()
    {
        $this->events = [
            [
                'id' => '1',
                'name' => 'Hack The Box CTF',
                'description' => 'A challenging CTF with a variety of categories including web, pwn, forensics, crypto, and reverse engineering. Test your skills against the best.',
                'start_time' => '2025-01-15T09:00:00Z',
                'end_time' => '2025-01-17T17:00:00Z',
                'is_paid' => true,
                'price' => 20,
                'cover_image_url' => 'https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615328442_4077514e.jpg',
                'max_participants' => 100,
                'is_active' => true,
                'created_at' => '2024-12-01T12:00:00Z',
            ],
            [
                'id' => '2',
                'name' => 'TryHackMe King of the Hill',
                'description' => 'A competitive king of the hill style CTF. Battle for control of a vulnerable machine and fend off other attackers to maintain your reign.',
                'start_time' => '2025-02-01T10:00:00Z',
                'end_time' => '2025-02-01T18:00:00Z',
                'is_paid' => false,
                'price' => 0,
                'cover_image_url' => 'https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615329816_87fb351b.jpg',
                'max_participants' => 200,
                'is_active' => true,
                'created_at' => '2024-12-15T12:00:00Z',
            ],
            [
                'id' => '3',
                'name' => 'Google CTF 2025',
                'description' => 'Google\'s annual CTF competition, featuring a wide range of creative and challenging problems designed by Google engineers.',
                'start_time' => '2025-06-10T00:00:00Z',
                'end_time' => '2026-06-12T00:00:00Z',
                'is_paid' => false,
                'price' => 0,
                'cover_image_url' => 'https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615325814_941623af.jpg',
                'is_active' => false,
                'created_at' => '2025-01-01T12:00:00Z',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.ctf-events', [
            'events' => $this->events,
        ])->layout('components.layouts.app');
    }
}
