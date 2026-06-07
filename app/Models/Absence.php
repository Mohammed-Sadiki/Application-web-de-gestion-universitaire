<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    protected $fillable = [
        'student_id',
        'module_id',
        'date',
        'justified',
        'justification_path',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
