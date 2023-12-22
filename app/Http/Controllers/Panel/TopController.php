<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\Session;
use App\Models\TgUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopController extends Controller
{
    public function __construct()
    {
        $this->middleware('simple.auth');
    }

    public function index(Request $request)
    {
        $seasons = \App\Models\Season::all();
        return view('panel.top.index', compact('seasons'));
    }

    public function data(Request $request)
    {
        $all = $request->all();

        if (empty($all['by'])) {
            $by = 'by_season';
        } else {
            $by = $all['by'];
        }

        if (empty($all['selected_season'])) {
            $selected_season = 0;
        } else {
            $selected_season = $all['selected_season'];
        }

        if (!empty($all['date_a'])) {
            $date_a = $all['date_a'];
        } else {
            $date_a = now()->format('Y-m-d');
        }

        if (!empty($all['date_b'])) {
            $date_b = $all['date_b'];
        } else {
            $date_b = now()->format('Y-m-d');
        }

        $scores = [];
        $users = [];

        if ($by == 'by_season') {
            $scores = Session::query()
                ->whereIn(
                    'tg_user_id',
                    DB::table('tg_users')
                        ->where('is_banned', 0)
                        ->where('has_token', 1)
                        ->select('id')
                )
                ->where('season_id', $selected_season)
                ->groupBy('tg_user_id')
                ->select([
                    'tg_user_id',
                    DB::raw("SUM(score) as score_sum")
                ])
                ->orderBy('score_sum', 'desc')
                ->limit(10)
                ->get();


            $top = Referral::query()
                ->with('user:id,first_name')
                ->whereNotIn('user_id', DB::table('tg_users')->where('is_banned', 1)->select('id'))
                ->where('season_id', $selected_season)
                ->where('referral_count', '>', 0)
                ->orderBy('referral_count', 'desc')
                ->limit(10)
                ->get();

            foreach ($top as $item) {
                $users[] = [
                    'id' => $item->user_id,
                    'first_name' => $item->user?->first_name ?? '-',
                    'ref_count' => $item->referral_count
                ];
            }
        }

        if ($by == 'by_range') {
            $d = Carbon::createFromFormat('Y-m-d', $date_a);
            $d->setHour(0);
            $d->setMinute(0);
            $d->setSecond(0);

            $d2 = Carbon::createFromFormat('Y-m-d', $date_b);
            $d2->setHour(23);
            $d2->setMinute(59);
            $d2->setSecond(59);

            $scores = Session::query()
                ->whereIn(
                    'tg_user_id',
                    DB::table('tg_users')
                        ->where('is_banned', 0)
                        ->where('has_token', 1)
                        ->select('id')
                )
                ->where('created_at', '>', $d)
                ->where('created_at', '<', $d2)
                ->groupBy('tg_user_id')
                ->select([
                    'tg_user_id',
                    DB::raw("SUM(score) as score_sum")
                ])
                ->orderBy('score_sum', 'desc')
                ->limit(10)
                ->get();


            $top = TgUser::query()
                ->where('referral_id', '!=', 0)
                ->where('is_banned', 0)
                ->where('captcha_passed', 1)
                ->where('captcha_subscribe', 1)
                ->whereBetween('created_at', [$d, $d2])
                ->whereNotIn('referral_id', DB::table('tg_users')->where('is_banned', 1)->select('id'))
                ->select([
                    'referral_id',
                    DB::raw('COUNT(*) as ref_count')
                ])
                ->groupBy('referral_id')
                ->get();

            foreach ($top as $item) {
                $user = TgUser::query()->find($item->referral_id);
                $item->first_name = $user?->first_name ?? "-";
                $users[] = $item;
            }
        }

        $scores_ = $scores;
        $scores = [];
        foreach ($scores_ as $item) {
            $u = TgUser::find($item->tg_user_id);
            $u->score = $item->score_sum;
            $scores[] = $u;
        }


        return response()->json([
            'scores' => $scores,
            'users' => $users
        ]);
    }
}
