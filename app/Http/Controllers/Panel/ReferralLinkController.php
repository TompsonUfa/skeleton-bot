<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\ReferralLink;
use App\Services\Telegram\Api\Api;
use Illuminate\Http\Request;

class ReferralLinkController extends Controller
{

    public function __construct()
    {
        $this->middleware('simple.auth');
    }

    public function index(Request $request)
    {
        $bot = new Api();
        $me = $bot->api->getMe();

        $url = 'https://t.me/' . $me->getUsername() . '?start=';
        $links = ReferralLink::query()
            ->withCount([
                'users',
                'usersWithCaptcha'
            ])
            ->paginate(50);
        foreach ($links as $link) {
            $link->link = $url . $link->hash;
        }
        return view('panel.referral.list', compact('links'));
    }

    public function add()
    {
        return view('panel.referral.add');
    }

    public function add_(Request $request)
    {
        $all = $request->all();
        $link = new ReferralLink();
        $link->hash = ReferralLink::generateHash();
        $link->caption = $all['caption'];
        $link->save();
        return redirect()->route('referral');
    }

    public function detail(Request $request, $id)
    {
        $link = ReferralLink::query()
            ->find($id);
        if (empty($link)) {
            abort(404);
        }
        return view('panel.referral.detail', compact('link'));
    }

    public function detail_(Request $request, $id)
    {
        $all = $request->all();
        $link = ReferralLink::query()
            ->find($id);
        if (empty($link)) {
            abort(404);
        }
        $link->caption = $all['caption'];
        $link->save();
        return redirect()->route('referral');
    }

}
