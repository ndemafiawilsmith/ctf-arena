<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CtfEvent;
use Carbon\Carbon;

class CtfEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'name' => 'Hack The Box CTF',
                'description' => 'A challenging CTF with a variety of categories including web, pwn, forensics, crypto, and reverse engineering. Test your skills against the best.',
                'start_time' => Carbon::parse('2025-01-15 09:00:00'),
                'end_time' => Carbon::parse('2026-01-17 17:00:00'),
                'is_paid' => false,
                'price' => 20.00,
                'cover_image_url' => 'https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615328442_4077514e.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'TryHackMe King of the Hill',
                'description' => 'A competitive king of the hill style CTF. Battle for control of a vulnerable machine and fend off other attackers to maintain your reign.',
                'start_time' => Carbon::parse('2025-02-01 10:00:00'),
                'end_time' => Carbon::parse('2025-02-01 18:00:00'),
                'is_paid' => false,
                'price' => 0.00,
                'cover_image_url' => 'https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615329816_87fb351b.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Google CTF 2025',
                'description' => 'Google\'s annual CTF competition, featuring a wide range of creative and challenging problems designed by Google engineers.',
                'start_time' => Carbon::parse('2025-06-10 00:00:00'),
                'end_time' => Carbon::parse('2026-06-12 00:00:00'),
                'is_paid' => false,
                'price' => 0.00,
                'cover_image_url' => 'https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615325814_941623af.jpg',
                'is_active' => false,
            ],
        ];

        foreach ($events as $event) {
            CtfEvent::create($event);
        }
    }
}
