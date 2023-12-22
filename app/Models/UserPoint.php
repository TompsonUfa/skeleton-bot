<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'point',
        'task_id',
        'source',
        'season_id',
        'project_id',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(TgUser::class, 'id', 'user_id');
    }
}
