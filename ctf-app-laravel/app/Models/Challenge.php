<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'ctf_event_id',
        'title',
        'description',
        'category',
        'difficulty',
        'points',
        'external_link',
        'flag_hash',
        'hints',
        'is_active',
    ];

    protected $casts = [
        'hints' => 'array',
    ];

    /**
     * Get the CTF event that owns the challenge.
     */
    public function ctfEvent()
    {
        return $this->belongsTo(CtfEvent::class);
    }

    /**
     * Get the solves for the challenge.
     */
    public function solves()
    {
        return $this->hasMany(Solve::class);
    }
}
