<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
//use App\Models\Language;
//use App\Models\TgUser;

class DashboardController extends Controller
{

    public function index()
    {
//        $tg_users = TgUser::query()
//            ->select(['id', 'wallet', 'captcha_passed',
//                'referral_enable', 'referral_id', 'language_id'])
//            ->get();
//
//        $langs_ = Language::all();
//        $langs = [];
//        foreach ($langs_ as $lang) {
//            $langs[$lang->id] = [
//                'caption' => $lang->caption,
//                'count' => 0,
//            ];
//        }
//
//        /**
//         * @var TgUser $tg_user
//         */
//        $tg_users_with_captcha = 0;
//        $tg_users_end_tasks = 0;
//        $tg_users_with_wallet = 0;
//        $tg_users_by_referral = 0;
//
//        foreach ($tg_users as $tg_user) {
//            if (isset($langs[$tg_user->language_id])) {
//                $langs[$tg_user->language_id]['count']++;
//            }
//
//            if ($tg_user->captcha_passed == 1) {
//                $tg_users_with_captcha++;
//            }
//            if ($tg_user->referral_enable == 1) {
//                $tg_users_end_tasks++;
//            }
//            if (!empty($tg_user->wallet)) {
//                $tg_users_with_wallet++;
//            }
//            if (!empty($tg_user->referral_id)) {
//                $tg_users_by_referral++;
//            }
//        }


        return view('panel.dashboard.index', [
//            'tg_users' => $tg_users->count(),
//            'tg_users_with_wallet' => $tg_users_with_wallet,
//            'tg_users_by_referral' => $tg_users_by_referral,
//            'tg_users_end_tasks' => $tg_users_end_tasks,
//            'tg_users_with_captcha' => $tg_users_with_captcha,
//            'langs' => $langs,
        ]);
    }


}
