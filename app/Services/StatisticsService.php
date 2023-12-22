<?php


namespace App\Services;

//use App\Models\Score;
//use App\Models\Session;
use App\Models\TgUser;
//use App\Models\TokenChannelSubscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StatisticsService
{
    public function dashboardData(): array
    {
        $users_count = TgUser::query()
            ->where('is_banned', 0)
            ->count();

//        $game_users_count = Score::query()
//            ->distinct('tg_user_id')
//            ->count();
//
//        $users_captcha_count = TgUser::query()
//            ->where('captcha_passed', 1)
//            ->where('is_banned', 0)
//            ->count();
//
//        $users_no_captcha_count = TgUser::query()
//            ->where('captcha_passed', 0)
//            ->where('is_banned', 0)
//            ->count();
//
//        $users_subscribe_captcha_count = TgUser::query()
//            ->where('captcha_passed', 1)
//            ->where('captcha_subscribe', 1)
//            ->where('is_banned', 0)
//            ->count();
//
//        $referral_users_count = TgUser::query()
//            ->where('referral_id', '!=', 0)
//            ->where('captcha_passed', 1)
//            ->where('captcha_subscribe', 1)
//            ->where('is_banned', 0)
//            ->count();
//
//        $banned_users_count = TgUser::query()
//            ->where('is_banned', 1)
//            ->count();
//
//        $users_subscribe_token_channel_count = TokenChannelSubscriber::query()
//            ->whereNotIn('user_id', DB::table('tg_users')->where('is_banned', 1)->select('id'))
//            ->count();
//
//        $total_game_scores = Session::query()
//            ->where('season_id', Season::getIdActiveSeason())
//            ->whereIn(
//                'tg_user_id',
//                DB::table('tg_users')
//                    ->where('is_banned', 0)
//                    ->where('has_token', 1)
//                    ->select('id')
//            )
//            ->sum('score');

        return [
            'users_count'  => $users_count,
//            'game_users_count' => $game_users_count,
//            'users_captcha_count' => $users_captcha_count,
//            'users_no_captcha_count' => $users_no_captcha_count,
//            'referral_users_count' => $referral_users_count,
//            'banned_users_count' => $banned_users_count,
//            'users_subscribe_token_channel_count' => $users_subscribe_token_channel_count,
//            'users_subscribe_captcha_count' => $users_subscribe_captcha_count,
//            'total_game_scores' => $total_game_scores,
        ];
    }

    private function rand_color()
    {
        return sprintf('#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255));
    }


    public function userLanguages($simpleData = false): array
    {
        $users = TgUser::query()
            ->where('captcha_passed', 1)
            ->select(['language_code'])
            ->get();

        $arr = [];
        foreach ($users as $user) {
            if ($user['language_code'] == null) {
                $user['language_code'] = 'Undefined lang';
            }
            if (empty($arr[$user['language_code']])) {
                $arr[$user['language_code']] = 1;
            } else {
                $arr[$user['language_code']]++;
            }
        }

        if($simpleData) {
            return $arr;
        }

        $result = [];
        $result['labels'] = [];
        $result['datasets'] = [];

        foreach ($arr as $k => $v) {
            $result['labels'][] = $k . '(' . $v . ')';
            $result['datasets'][0]['data'][] = $v;
            $result['datasets'][0]['backgroundColor'][] = $this->rand_color();
        }

        return $result;
    }

    public function userGrowth(array $requestData): array
    {
        /**
         * @var Carbon $start_date
         * @var Carbon $end_date
         * */
        $start_date = null;
        $end_date = null;
        if (array_key_exists('range', $requestData)) {
            $start_date = Carbon::createFromDate($requestData['start_date']);
            $end_date = Carbon::createFromDate($requestData['end_date']);
        } else if (array_key_exists('current_week', $requestData)) {
            $start_date = Carbon::now()->subDays(7);
            $end_date = Carbon::now();
        } else if (array_key_exists('current_month', $requestData)) {
            $days_in_month = Carbon::now()->daysInMonth;
            $start_date = Carbon::now()->subDays($days_in_month);
            $end_date = Carbon::now();
        }

        $getData = TgUser::query()
            ->orderBy('created_at')
            ->where('captcha_passed', 1)
            ->select(['created_at']);

        if (!is_null($start_date)) {
            $start_date->setHours(0);
            $start_date->setMinutes(0);
            $start_date->setSeconds(0);
            $start_date = $start_date->toDateTimeString();
            $end_date->setHours(23);
            $end_date->setMinutes(59);
            $end_date->setSeconds(59);
            $end_date = $end_date->toDateTimeString();
            $getData->whereBetween('created_at', [$start_date, $end_date]);
        }

        $res = [];

        foreach ($getData->cursor() as $data) {
            $d = Carbon::createFromTimeString($data->created_at)->format('d.m.Y');
            if (empty($res[$d])) {
                $res[$d] = 1;
            } else {
                $res[$d]++;
            }
        }

        $result = [];
        $result['labels'] = [];
        $result['datasets'] = [];

        $a = $this->rand_color();
        $result['datasets'][0] = [
            'label' => "User growth",
            'backgroundColor' => $a,
            'borderColor' => $a,
            'data' => []
        ];

        $sum = 0;
        foreach ($res as $r => $v) {
            $sum += $v;
            $result['labels'][] = $r;
            $result['datasets'][0]['data'][] = $sum;
            $result['datasets'][0]['fill'][] = false;
        }

        return $result;
    }

//    public function gameLaunch(array $requestData)
//    {
//        /**
//         * @var Carbon $start_date
//         * @var Carbon $end_date
//         * */
//        $start_date = null;
//        $end_date = null;
//        if (array_key_exists('range', $requestData)) {
//            $start_date = Carbon::createFromDate($requestData['start_date']);
//            $end_date = Carbon::createFromDate($requestData['end_date']);
//        } else if (array_key_exists('current_week', $requestData)) {
//            $start_date = Carbon::now()->subDays(7);
//            $end_date = Carbon::now();
//        } else if (array_key_exists('current_month', $requestData)) {
//            $days_in_month = Carbon::now()->daysInMonth;
//            $start_date = Carbon::now()->subDays($days_in_month);
//            $end_date = Carbon::now();
//        }
//
//        $getData = Session::query()
//            ->select(['created_at', 'attempts']);
//        if (!is_null($start_date)) {
//            $start_date->setHours(0);
//            $start_date->setMinutes(0);
//            $start_date->setSeconds(0);
//            $start_date = $start_date->toDateTimeString();
//            $end_date->setHours(23);
//            $end_date->setMinutes(59);
//            $end_date->setSeconds(59);
//            $end_date = $end_date->toDateTimeString();
//            $getData->whereBetween('created_at', [$start_date, $end_date]);
//        }
//
//        $res = [];
//
//        foreach ($getData->cursor() as $data) {
//            $d = Carbon::createFromTimeString($data->created_at)->format('d.m');
//            if (empty($res[$d])) {
//                $res[$d] = $data->attempts;
//            } else {
//                $res[$d] += $data->attempts;
//            }
//        }
//
//        $result = [];
//        $result['labels'] = [];
//        $result['datasets'] = [];
//
//        foreach ($res as $r => $v) {
//            $result['labels'][] = $r;
//        }
//
//        $a = $this->rand_color();
//        $result['datasets'][0] = [
//            'label' => "Game launch",
//            'backgroundColor' => $a,
//            'borderColor' => $a,
//            'data' => []
//        ];
//
//
//        foreach ($res as $r => $v) {
//            $result['datasets'][0]['data'][] = $v;
//            $result['datasets'][0]['fill'][] = false;
//        }
//
//        return $result;
//    }
}
