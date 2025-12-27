<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtfEvent extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'description',
        'start_time',
        'end_time',
        'is_paid',
        'price',
        'cover_image_url',
        'is_active',
        'is_rewarded',
        'first_prize',
        'second_prize',
        'third_prize',
        'sponsor',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_paid' => 'boolean',
        'is_active' => 'boolean',
        'is_rewarded' => 'boolean',
    ];

    /**
     * Get the challenges for the CTF event.
     */
    public function challenges()
    {
        return $this->hasMany(Challenge::class);
    }

    public function accesses()
    {
        return $this->hasMany(EventAccess::class);
    }
}
