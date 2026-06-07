<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'capacity', 'type'])]
class Room extends Model
{
    use HasFactory;

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function reservations()
    {
        return $this->hasMany(RoomReservation::class);
    }
}
