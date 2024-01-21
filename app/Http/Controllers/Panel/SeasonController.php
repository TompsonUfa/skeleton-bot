<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Season;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SeasonController extends Controller
{

    public function __construct()
    {
        $this->middleware('simple.auth');
    }

    public function index()
    {
        $seasons = Season::all();
        return view('panel.seasons.list', compact('seasons'));
    }

    public function add()
    {
        return view('panel.seasons.add');
    }

    public function add_(Request $request)
    {
        $all = $request->all();
        \App\Services\Season::createNewSeason($all['caption'], $all['stop_at_info']);
        return redirect()->route('seasons');
    }

    public function detail($id)
    {
        /**
         * @var Season $season
         */
        $season = Season::query()
            ->find($id);
        if (empty($season)) {
            abort(404);
        }
        if (empty($season->stop_at_info)) {
            $season->stop_at_info = Carbon::now();
        }
        return view('panel.seasons.detail', compact('season'));
    }

    public function detail_(Request $request, $id)
    {
        $all = $request->all();
        /**
         * @var Season $season
         */
        $season = Season::query()
            ->find($id);
        if (empty($season)) {
            abort(404);
        }
        $season->caption = $all['caption'];
        $season->stop_at_info = Carbon::createFromTimestamp(strtotime($all['stop_at_info']));
        $season->save();
        return redirect()->route('seasons');
    }

    public function active($id)
    {
        $season = Season::query()
            ->find($id);
        if (empty($season)) {
            abort(404);
        }
        \App\Services\Season::setActiveSeason($id);
        return redirect()->route('seasons');
    }
}
