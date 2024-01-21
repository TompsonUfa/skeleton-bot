<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSend
 */
class Send extends Model
{
    use HasFactory;

    protected $casts = [
        'publish_at' => 'datetime',
        'recipients' => 'json',
    ];

    public function units_()
    {
        return TgUnit::query()
            ->where('model_type', self::class)
            ->where('model_id', $this->id)
            ->get();
    }

}
