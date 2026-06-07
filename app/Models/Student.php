<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'group_id', 'cne'])]
class Student extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }
}
