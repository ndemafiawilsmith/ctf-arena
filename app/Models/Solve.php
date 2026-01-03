<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solve extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'challenge_id',
    ];

    /**
     * Get the user that solved the challenge.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the challenge that was solved.
     */
    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}
