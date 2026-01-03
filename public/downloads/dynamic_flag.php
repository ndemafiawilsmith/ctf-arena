<?php
// CONFIGURATION
// This SEED must match the 'flag_seed' set in the Laravel Admin Panel for the challenge.
$SEED = "qwerty";

// Get User ID from POST or GET
$user_id = "019b5f18-d871-70c0-94b0-81d7795464f2";

if (!$user_id) {
    die("Error: Missing user_id parameter");
}

// Generate Flag: SHA256(Seed + User_ID)
// We take the first 12 chars of the hash to keep it manageable
$raw_hash = hash('sha256', $SEED . $user_id);
$flag = "CTF{" . substr($raw_hash, 0, 12) . "}";

echo $flag;
