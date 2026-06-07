<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'module_id',
        'professor_id',
        'content',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
