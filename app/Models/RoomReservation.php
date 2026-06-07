<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomReservation extends Model
{
    protected $fillable = [
        'room_id',
        'professor_id',
        'date',
        'start_time',
        'end_time',
        'reason',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }
}
