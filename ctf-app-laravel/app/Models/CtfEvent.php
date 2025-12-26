<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtfEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_time',
        'end_time',
        'is_paid',
        'price',
        'cover_image_url',
        'is_active',
    ];

    /**
     * Get the challenges for the CTF event.
     */
    public function challenges()
    {
        return $this->hasMany(Challenge::class);
    }
}
