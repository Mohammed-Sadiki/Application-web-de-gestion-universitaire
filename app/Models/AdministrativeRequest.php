<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministrativeRequest extends Model
{
    protected $fillable = [
        'user_id',
        'professor_id',
        'type',
        'status',
        'reason',
        'file_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }
}
