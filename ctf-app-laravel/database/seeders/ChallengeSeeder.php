<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CtfEvent;
use App\Models\Challenge;

class ChallengeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the "Hack The Box CTF" event we seeded earlier
        $event = CtfEvent::where('name', 'Hack The Box CTF')->first();

        if (!$event) {
            return;
        }

        $challenges = [
            [
                'title' => 'SQL Injection 101',
                'description' => 'Can you bypass the login form? The administrator relies on simple string concatenation for queries.',
                'category' => 'Web',
                'difficulty' => 'easy',
                'points' => 100,
                'external_link' => '#',
                'flag_hash' => hash('sha256', 'flag{sql_injection_master}'),
                'is_active' => true,
            ],
            [
                'title' => 'Buffer Overflow Basic',
                'description' => 'A simple buffer overflow challenge. Overwrite the return address to jump to the win function.',
                'category' => 'Pwn',
                'difficulty' => 'medium',
                'points' => 250,
                'external_link' => '#',
                'flag_hash' => hash('sha256', 'flag{buffer_overflow_king}'),
                'is_active' => true,
            ],
            [
                'title' => 'Missing Pixel',
                'description' => 'There is something hidden in this image. Can you find it using steganography tools?',
                'category' => 'Forensics',
                'difficulty' => 'easy',
                'points' => 100,
                'external_link' => '#',
                'flag_hash' => hash('sha256', 'flag{stego_master}'),
                'is_active' => true,
            ],
            [
                'title' => 'RSA Weak Key',
                'description' => 'The public key exponent is too small. Recover the private key and decrypt the flag.',
                'category' => 'Crypto',
                'difficulty' => 'hard',
                'points' => 400,
                'external_link' => '#',
                'flag_hash' => hash('sha256', 'flag{rsa_is_broken}'),
                'is_active' => true,
            ],
            [
                'title' => 'Reverse Me',
                'description' => 'Reverse engineer this binary to find the hardcoded password.',
                'category' => 'Reverse',
                'difficulty' => 'medium',
                'points' => 200,
                'external_link' => '#',
                'flag_hash' => hash('sha256', 'flag{reverse_engineer_god}'),
                'is_active' => true,
            ],
            [
                'title' => 'Sanity Check',
                'description' => 'Just a warm-up. The flag is flag{welcome_to_ctf}.',
                'category' => 'Misc',
                'difficulty' => 'easy',
                'points' => 50,
                'external_link' => '#',
                'flag_hash' => hash('sha256', 'flag{welcome_to_ctf}'),
                'is_active' => true,
            ],
        ];

        foreach ($challenges as $challenge) {
            $event->challenges()->create($challenge);
        }
    }
}
