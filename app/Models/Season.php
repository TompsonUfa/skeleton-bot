<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSeason
 */
class Season extends Model
{
    use HasFactory;

    protected $casts = [
        'start_at' => 'datetime',
        'stop_at' => 'datetime',
        'stop_at_info' => 'datetime',
    ];
}
