<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @mixin IdeHelperReferralLink
 */
class ReferralLink extends Model
{
    use HasFactory;

    static public function generateHash()
    {
        do {
            $code = Str::random(10);
            $ref_ = ReferralLink::query()
                ->where('hash', $code)
                ->first();
        } while (!empty($ref_));
        return $code;
    }

    public function users(): HasMany
    {
        return $this->hasMany(TgUser::class, 'referral_link_id', 'id');
    }

    public function usersWithCaptcha(): HasMany
    {
        return $this->hasMany(TgUser::class, 'referral_link_id', 'id')
            ->where('captcha_passed', 1)
            ->where('captcha_subscribe', 1);
    }
}
