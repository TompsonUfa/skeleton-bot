<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Send;
use App\Models\TgUser;
use App\Services\SendService;
use App\Services\UnitService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SendController extends Controller
{

    public function index()
    {
        $sends = Send::query()
            ->orderBy('id', 'desc')
            ->get();
        return view('panel.sends.list', compact('sends'));
    }

    public function add()
    {
        $count_users = TgUser::query()
            ->where('banned', 0)
            ->count();

        return view('panel.sends.add', compact('count_users'));
    }

    public function add_(Request $request)
    {
        $all = $request->all();
        $send = new Send();
        $send->caption = $all['caption'];
        $send->publish_at = Carbon::make($all['publish_at_d'] . ' ' . $all['publish_at_t']);
        if ($request->has('is_active')) {
            $send->is_active = 1;
        } else {
            $send->is_active = 0;
        }
        $arr = [];
        $arr['type'] = $all['recipients'];
        $send->recipients = $arr;
        $send->save();
        $service = new UnitService();
        $service->makeUnits(Send::class, $send->id, 0, $request);
        return redirect()->route('sends');
    }

    public function detail(Request $request, $id)
    {
        $send = Send::query()
            ->find($id);
        if (empty($send)) {
            abort(404);
        }
        $count_users = TgUser::query()
            ->select(['language_code', 'selected_language'])
            ->where('banned', 0)
            ->count();

        return view('panel.sends.detail', compact('send', 'count_users'));
    }

    public function detail_(Request $request, $id)
    {
        $all = $request->all();

        /**
         * @var Send $send
         */
        $send = Send::query()
            ->find($id);
        if (empty($send)) {
            abort(404);
        }
        if ($send->is_publish) {
            if ($request->has('is_active')) {
                $send->is_active = 1;
                $send->save();
            } else {
                $send->is_active = 0;
                $send->save();
            }
            return redirect()->route('sends');
        }
        if ($request->has('is_active')) {
            $send->is_active = 1;
        } else {
            $send->is_active = 0;
        }
        $send->publish_at = Carbon::make($all['publish_at_d'] . ' ' . $all['publish_at_t']);
        $send->caption = $all['caption'];

        $arr = [];
        $arr['type'] = $all['recipients'];
        $send->recipients = $arr;

        $send->save();

        $service = new UnitService();
        $service->updateUnits(Send::class, $send->id, 0, $request);
        return redirect()->route('sends');

    }

    public function stop(Request $request, $id)
    {
        $send = Send::query()
            ->find($id);
        /**
         * @var Send $send
         */
        if (empty($send)) {
            abort(404);
        }
        $send->is_active = 0;
        $send->save();
        return redirect()->route('sends.detail', $id);
    }

    public function delete_messages(Request $request, $id)
    {
        /**
         * @var Send $send
         */
        $send = Send::query()
            ->find($id);
        if (empty($send)) {
            abort(404);
        }
        $send->is_active = 0;
        $send->save();

        $service = new SendService();
        $service->delete_messages($id);

        return redirect()->route('sends.detail', $id);
    }

}
