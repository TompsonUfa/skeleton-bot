<?php

namespace App\Http\Controllers\Panel;

use App\Helpers\BotActionHelper;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Param;
use App\Services\Telegram\Screens\CaptchaScreen;
use App\Services\Telegram\Screens\CaptchaSubscribeScreen;
//use App\Services\Telegram\Screens\GameScreen;
//use App\Services\Telegram\Screens\ReferralScreen;
use App\Services\Telegram\Screens\SendScreen;
use App\Services\Telegram\Screens\StartScreen;
//use App\Services\Telegram\Screens\TaskScreen;
//use App\Services\Telegram\Screens\TokenScreen;
//use App\Services\Telegram\Screens\WalletScreen;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware('simple.auth');
    }

    public function index()
    {
        $languages = Param::get('languages');
        if (empty($languages) || $languages == '[]') {
            $languages = [];
            $languages[] = [
                'code' => 'en',
                'caption' => 'Eng',
                'is_active' => 1,
            ];
            Param::set('languages', json_encode($languages));
            $languages = Param::get('languages');
        }
        $languages = json_decode($languages, true);
        return view('panel.languages.list', compact('languages'));
    }

    public function delete(Request $request, $code)
    {
        $languages = Param::get('languages');
        $languages = json_decode($languages, true);
        $language = [];
        foreach ($languages as $item) {
            if ($item['code'] == $code) {
                $language = $item;
                break;
            }
        }
        if (empty($language)) {
            abort(404);
        }
        Content::query()
            ->where('lang', $language['code'])
            ->delete();
        $new = [];
        foreach ($languages as $item) {
            if ($item['code'] != $code) {
                $new[] = $item;
            }
        }
        Param::set('languages', json_encode($new));
        return redirect()->route('languages');
    }

    public function add()
    {
        return view('panel.languages.add');
    }

    public function add_(Request $request)
    {
        $all = $request->all();
        $languages = Param::get('languages');
        $languages = json_decode($languages, true);
        foreach ($languages as $item) {
            if ($item['code'] == $all['code']) {
                dd('language code already in use');
            }
        }
        $languages[] = [
            'code' => $all['code'],
            'caption' => $all['caption'],
            'is_active' => 0,
        ];
        Param::set('languages', json_encode($languages));
        return redirect()->route('languages');
    }

    public function detail(Request $request, $code)
    {
        $languages = Param::get('languages');
        $languages = json_decode($languages, true);
        $language = [];
        foreach ($languages as $item) {
            if ($item['code'] == $code) {
                $language = $item;
                break;
            }
        }
        if (empty($language)) {
            abort(404);
        }

        $macro_indexes = [];
//        $macro_indexes = array_merge($macro_indexes, CaptchaScreen::$macro);
//        $macro_indexes = array_merge($macro_indexes, CaptchaSubscribeScreen::$macro);
        $macro_indexes = array_merge($macro_indexes, StartScreen::$macro);
//        $macro_indexes = array_merge($macro_indexes, WalletScreen::$macro);
//        $macro_indexes = array_merge($macro_indexes, ReferralScreen::$macro);
        $macro_indexes = array_merge($macro_indexes, SendScreen::$macro);
//        $macro_indexes = array_merge($macro_indexes, TaskScreen::$macro);
//        $macro_indexes = array_merge($macro_indexes, TokenScreen::$macro);
//        $macro_indexes = array_merge($macro_indexes, GameScreen::$macro);
        $macro = [];
        foreach ($macro_indexes as $index) {
            $data = '';
            /**
             * @var Content $lmacro
             */
            $lmacro = Content::query()
                ->where('macro', $index)
                ->where('lang', $code)
                ->first();
            if (!empty($lmacro)) {
                $data = $lmacro->data;
            }
            $macro[$index] = $data;
        }

        return view('panel.languages.detail', compact('language', 'macro'));
    }

    public function detail_(Request $request, $code)
    {
        $all = $request->all();
        $languages = Param::get('languages');
        $languages = json_decode($languages, true);
        $language = [];

        foreach ($languages as $item) {
            if ($item['code'] == $code) {
                $language = $item;
                break;
            }
        }
        if (empty($language)) {
            abort(404);
        }

        Content::query()
            ->where('is_notif', 0)
            ->where('lang', $code)
            ->delete();

        foreach ($all['macro'] as $k => $v) {
            if (empty($v)) {
                continue;
            }
            $lmacro = new Content();
            $lmacro->macro = $k;
            $lmacro->data = $v;
            $lmacro->lang = $code;
            $lmacro->save();
        }
        foreach ($languages as &$item) {
            if ($item['code'] == $code) {
                if ($request->has('is_active')) {
                    $item['is_active'] = 1;
                } else {
                    $item['is_active'] = 0;
                }
                $item['caption'] = $all['caption'];
                break;
            }
        }

        Param::set('languages', json_encode($languages));
        return redirect()->route('languages');
    }

    public function notifications($code)
    {
        $languages = Param::get('languages');
        $languages = json_decode($languages, true);
        $language = [];
        foreach ($languages as $item) {
            if ($item['code'] == $code) {
                $language = $item;
                break;
            }
        }
        if (empty($language)) {
            abort(404);
        }

        $macro_indexes = BotActionHelper::getMacros();
        $macro = [];
        foreach ($macro_indexes as $index) {
            $data = '';
            /**
             * @var Content $lmacro
             */
            $lmacro = Content::query()
                ->where('macro', $index)
                ->where('lang', $code)
                ->first();
            if (!empty($lmacro)) {
                $data = $lmacro->data;
            }
            $macro[$index] = $data;
        }

        return view('panel.languages.notifications', compact('language', 'macro'));
    }

    public function notifications_(Request $request, $code)
    {
        $all = $request->all();
        $languages = Param::get('languages');
        $languages = json_decode($languages, true);
        $language = [];

        foreach ($languages as $item) {
            if ($item['code'] == $code) {
                $language = $item;
                break;
            }
        }
        if (empty($language)) {
            abort(404);
        }

        Content::query()
            ->where('is_notif', 1)
            ->where('lang', $code)
            ->delete();
        foreach ($all['macro'] as $k => $v) {
            if (empty($v)) {
                continue;
            }
            $lmacro = new Content();
            $lmacro->macro = $k;
            $lmacro->data = $v;
            $lmacro->lang = $code;
            $lmacro->is_notif = 1;
            $lmacro->save();
        }

        return redirect()->route('languages');
    }
}
