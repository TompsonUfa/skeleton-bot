<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\Session;
use App\Models\SessionHistory;
use App\Models\TgUser;
use App\Services\Season;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function users(Request $request)
    {
        $se = $request->get('se');
        $users = TgUser::query()
            ->withSum('referrals', 'referral_count')
            ->when(!empty($se), fn($q) => $q->searchUser($se))
            ->paginate(50);
        $count = $users->total();

        return view('panel.users.list', compact('users',
            'count'));
    }

    public function usersDetail($id)
    {
        /* @var TgUser $user */
        $user = TgUser::query()
            ->findOrFail($id);

        //dd($user->referrals->sum('referral_count'));

        $seasonId = Season::getIdActiveSeason();
        $totalPoints = $user->userPoints()->sum('point');
        $seasonPoints = $user->userPoints()->whereSeasonId($seasonId)->sum('point');
        $totalReferralCount = Referral::whereUserId($user->id)
            ->sum('referral_count');
        $seasonReferralCount = Referral::whereUserId($user->id)
            ->whereSeasonId($seasonId)
            ->first()?->referral_count ?? 0;

        return view('panel.users.detail', compact('user', 'totalPoints', 'seasonPoints', 'totalReferralCount', 'seasonReferralCount'));
    }

    public function banUser($id)
    {
        /* @var TgUser $user */
        $user = TgUser::query()->find($id);
        if ($user) {
            $user->is_banned = 1;
            $user->save();
        }
        return redirect()->back();
    }

    public function unbanUser($id)
    {
        /* @var TgUser $user */
        $user = TgUser::query()->find($id);
        if ($user) {
            $user->is_banned = 0;
            $user->save();
        }
        return redirect()->back();
    }

    public function referrals(Request $request, $id)
    {
        $se = $request->get('se');
        $user = TgUser::query()
            ->findOrFail($id);

        $referrals = TgUser::where('referral_id', $id)
            ->searchUser($se)
            ->paginate(50);

        $count = $referrals->total();

        return view('panel.users.referrals', compact('referrals', 'count', 'user'));
    }

    private function rand_color()
    {
        return sprintf('#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255));
    }


    public function gameStats($id)
    {

        $data = [];

        $sessions = Session::query()
            ->where('tg_user_id', $id)
            ->get();


        foreach ($sessions as $session) {

            $a = $this->rand_color();
            $tmp = [];
            $tmp['labels'] = [];
            $tmp['datasets'] = [];
            $tmp['datasets'][0] = [
                'label' => $session->hash,
                'backgroundColor' => $a,
                'borderColor' => $a,
                'data' => []
            ];
            $s_hs = SessionHistory::query()
                ->where('hash', $session->hash)
                ->get();

            if ($s_hs->count() == 0) {
                continue;
            }

            $i = 0;
            foreach ($s_hs as $s) {
                $tmp['labels'][] = $i++;
                $tmp['datasets'][0]['data'][] = $s->score;
                $tmp['datasets'][0]['fill'][] = false;
            }

            $data[] = json_encode($tmp);
        }

        return view('panel.users.game_stats', compact('data'));

    }

}
