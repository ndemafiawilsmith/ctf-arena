<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChallengesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cyberStrikeEventId = DB::table('ctf_events')->where('name', 'CyberStrike 2025')->value('id');
        $binaryBlitzEventId = DB::table('ctf_events')->where('name', 'Binary Blitz')->value('id');

        if ($cyberStrikeEventId) {
            DB::table('challenges')->insert([
                [
                    'ctf_event_id' => $cyberStrikeEventId,
                    'title' => 'SQLi Warmup',
                    'description' => 'Exploit a classic SQL injection to retrieve the admin flag.',
                    'category' => 'Web',
                    'difficulty' => 'easy',
                    'points' => 100,
                    'external_link' => 'https://tryhackme.com/room/sqlinjection',
                    'flag_hash' => hash('sha256', 'CTF{sql_injection_master}'),
                    'is_active' => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'ctf_event_id' => $cyberStrikeEventId,
                    'title' => 'Auth Bypass',
                    'description' => 'Find a logic flaw and bypass authentication.',
                    'category' => 'Web',
                    'difficulty' => 'medium',
                    'points' => 200,
                    'external_link' => 'https://tryhackme.com/room/authentication',
                    'flag_hash' => hash('sha256', 'CTF{auth_bypass}'),
                    'is_active' => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ]);
        }

        if ($binaryBlitzEventId) {
            DB::table('challenges')->insert([
                [
                    'ctf_event_id' => $binaryBlitzEventId,
                    'title' => 'Crack the Binary',
                    'description' => 'Reverse engineer the binary and extract the hidden flag.',
                    'category' => 'Reverse',
                    'difficulty' => 'medium',
                    'points' => 250,
                    'external_link' => 'https://tryhackme.com/room/reversing',
                    'flag_hash' => hash('sha256', 'CTF{binary_owned}'),
                    'is_active' => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ]);
        }
    }
}
