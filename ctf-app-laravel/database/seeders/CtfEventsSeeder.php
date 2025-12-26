<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CtfEventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ctf_events')->insert([
            [
                'name' => 'CyberStrike 2025',
                'description' => 'The ultimate web exploitation challenge. Test your skills against real-world vulnerabilities.',
                'start_time' => Carbon::now()->addDay(),
                'end_time' => Carbon::now()->addDays(3),
                'is_paid' => true,
                'price' => 49.99,
                'cover_image_url' => 'https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615325814_941623af.jpg',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Binary Blitz',
                'description' => 'Reverse engineering and binary exploitation. Crack the code, own the system.',
                'start_time' => Carbon::now(),
                'end_time' => Carbon::now()->addDays(7),
                'is_paid' => false,
                'price' => 0,
                'cover_image_url' => 'https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615328442_4077514e.jpg',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Crypto Chaos',
                'description' => 'Cryptographic challenges from basic ciphers to advanced cryptanalysis.',
                'start_time' => Carbon::now(),
                'end_time' => Carbon::now()->addDays(5),
                'is_paid' => true,
                'price' => 29.99,
                'cover_image_url' => 'https://d64gsuwffb70l.cloudfront.net/694c683736b11c8f7b89a569_1766615329816_87fb351b.jpg',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
