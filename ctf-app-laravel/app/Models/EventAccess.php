<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventAccess extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'ctf_event_id',
        'transaction_reference',
        'amount_paid',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(CtfEvent::class, 'ctf_event_id');
    }
}
