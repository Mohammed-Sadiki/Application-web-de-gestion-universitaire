<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonLog extends Model
{
    protected $fillable = [
        'module_id',
        'professor_id',
        'date',
        'start_time',
        'end_time',
        'objective',
        'type',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }
}
