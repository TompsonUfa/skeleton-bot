<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @mixin IdeHelperTgUser
 */
class TgUser extends Model
{
    use HasFactory;

    protected $casts = [
        'last_action_time' => 'datetime',
        'last_checking_token_time' => 'datetime'
    ];

    static public function findByTid($tid)
    {
        return self::query()
            ->where('tid', $tid)
            ->first();
    }

    static public function generateHash($type): string
    {
        do {
            $code = Str::random(8);
            $user_ = TgUser::query()
                ->where($type, $code)
                ->first();
        } while (!empty($user_));
        return $code;
    }

    public function scopeSearchUser(Builder $query, $search): Builder
    {
        return $query
            ->where(function ($q) use ($search) {
                $q->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('tid', 'like', '%' . $search . '%');
            });
    }

    public function userPoints(): HasMany
    {
        return $this->hasMany(UserPoint::class, 'user_id', 'id');
    }

    public function userTasks(): HasMany
    {
        return $this->hasMany(UserTask::class, 'user_id', 'id');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class, 'user_id', 'id');
    }
}
