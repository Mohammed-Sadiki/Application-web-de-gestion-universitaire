<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'specialty'])]
class Professor extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function lessonLogs()
    {
        return $this->hasMany(LessonLog::class);
    }

    public function courseMaterials()
    {
        return $this->hasMany(CourseMaterial::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function reservations()
    {
        return $this->hasMany(RoomReservation::class);
    }
}
