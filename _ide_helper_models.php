<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Content
 *
 * @property int $id
 * @property string $macro
 * @property string $data
 * @property string $lang
 * @property int $is_notif
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Content newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Content newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Content query()
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereIsNotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereMacro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperContent {}
}

namespace App\Models{
/**
 * App\Models\Param
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Param newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Param newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Param query()
 * @method static \Illuminate\Database\Eloquent\Builder|Param whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Param whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Param whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Param whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Param whereValue($value)
 * @mixin \Eloquent
 */
	class IdeHelperParam {}
}

namespace App\Models{
/**
 * App\Models\Referral
 *
 * @property int $id
 * @property int $user_id
 * @property int $referral_count
 * @property int $season_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TgUser|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Referral newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Referral newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Referral query()
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereReferralCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereSeasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereUserId($value)
 * @mixin \Eloquent
 */
	class IdeHelperReferral {}
}

namespace App\Models{
/**
 * App\Models\ReferralLink
 *
 * @property int $id
 * @property string $caption
 * @property string $hash
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TgUser> $users
 * @property-read int|null $users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TgUser> $usersWithCaptcha
 * @property-read int|null $users_with_captcha_count
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralLink whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralLink whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralLink whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperReferralLink {}
}

namespace App\Models{
/**
 * App\Models\Season
 *
 * @property int $id
 * @property string $caption
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $start_at
 * @property \Illuminate\Support\Carbon|null $stop_at
 * @property \Illuminate\Support\Carbon|null $stop_at_info
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Season newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Season newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Season query()
 * @method static \Illuminate\Database\Eloquent\Builder|Season whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Season whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Season whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Season whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Season whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Season whereStopAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Season whereStopAtInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Season whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperSeason {}
}

namespace App\Models{
/**
 * App\Models\TgGroup
 *
 * @property int $id
 * @property int $tid
 * @property string|null $name
 * @property string|null $link
 * @property string|null $username
 * @property string $status
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TgGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TgGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TgGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|TgGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgGroup whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgGroup whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgGroup whereTid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgGroup whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgGroup whereUsername($value)
 * @mixin \Eloquent
 */
	class IdeHelperTgGroup {}
}

namespace App\Models{
/**
 * App\Models\TgHashRoute
 *
 * @property int $id
 * @property string $hash
 * @property string $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TgHashRoute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TgHashRoute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TgHashRoute query()
 * @method static \Illuminate\Database\Eloquent\Builder|TgHashRoute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgHashRoute whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgHashRoute whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgHashRoute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgHashRoute whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperTgHashRoute {}
}

namespace App\Models{
/**
 * App\Models\TgUser
 *
 * @property int $id
 * @property int $tid
 * @property int $is_banned
 * @property int $banned
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $username
 * @property string $wallet
 * @property string $referral_hash
 * @property string|null $selected_language
 * @property int $season_id
 * @property int $has_token
 * @property int $referral_count
 * @property int $referral_counted
 * @property int $referral_id
 * @property string|null $referral_at
 * @property string|null $unlock_at
 * @property int $captcha_passed
 * @property int $captcha_attempts
 * @property int $captcha_value
 * @property int $captcha_subscribe
 * @property int|null $last_action
 * @property \Illuminate\Support\Carbon|null $last_action_time
 * @property int $action_notif_step
 * @property string|null $language_code
 * @property \Illuminate\Support\Carbon|null $last_checking_token_time
 * @property int $referral_link_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Referral> $referrals
 * @property-read int|null $referrals_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserPoint> $userPoints
 * @property-read int|null $user_points_count
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser searchUser($search)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereActionNotifStep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereBanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereCaptchaAttempts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereCaptchaPassed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereCaptchaSubscribe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereCaptchaValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereHasToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereIsBanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereLanguageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereLastAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereLastActionTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereLastCheckingTokenTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereReferralAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereReferralCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereReferralCounted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereReferralHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereReferralId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereReferralLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereSeasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereSelectedLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereTid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereUnlockAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgUser whereWallet($value)
 * @mixin \Eloquent
 */
	class IdeHelperTgUser {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperUser {}
}

namespace App\Models{
/**
 * App\Models\UserPoint
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $task_id
 * @property int $point
 * @property int $season_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TgUser|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserPoint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPoint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPoint query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPoint whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPoint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPoint wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPoint whereSeasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPoint whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPoint whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPoint whereUserId($value)
 * @mixin \Eloquent
 */
	class IdeHelperUserPoint {}
}

