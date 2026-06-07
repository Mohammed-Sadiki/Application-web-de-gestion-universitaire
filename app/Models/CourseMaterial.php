<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseMaterial extends Model
{
    protected $fillable = [
        'module_id',
        'professor_id',
        'title',
        'file_path',
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
