<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin IdeHelperReferral
 */
class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'referral_count',
        'season_id'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(TgUser::class, 'id', 'user_id');
    }
}
