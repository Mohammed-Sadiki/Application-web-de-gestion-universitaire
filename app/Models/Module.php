<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'department_id'])]
class Module extends Model
{
    use HasFactory;

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function professors()
    {
        return $this->belongsToMany(Professor::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
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
}
