<?php

namespace App\Services;

use Carbon\Carbon;

class Season
{
    protected $casts = [
        'start_at' => 'datetime',
        'stop_at' => 'datetime',
    ];

    static function getIdActiveSeason()
    {
        $season = \App\Models\Season::query()
            ->where('is_active', 1)
            ->first();
        return $season->id ?? 0;
    }

    static function createNewSeason($caption, $stop_at_info)
    {
        $season = new \App\Models\Season();
        $season->caption = $caption;
        $season->stop_at_info = Carbon::createFromTimestamp(strtotime($stop_at_info));
        $season->save();
        return $season->id;
    }

    static function setActiveSeason($season_id)
    {
        $season = \App\Models\Season::find($season_id);
        if (empty($season) || $season->is_active == 1) {
            return;
        }
        $seasons = \App\Models\Season::query()
            ->where('is_active', 1)
            ->get();
        foreach ($seasons as $season) {
            $season->is_active = 0;
            $season->stop_at = Carbon::now();
            $season->save();
        }
        $season = \App\Models\Season::find($season_id);
        $season->is_active = 1;
        $season->start_at = Carbon::now();
        $season->save();
    }

    static function getAllSeasons()
    {
        return \App\Models\Season::all();
    }

    static function daysToEnd(): int
    {
        /**
         * @var \App\Models\Season $season
         */
        $season = \App\Models\Season::query()
            ->where('is_active', 1)
            ->first();
        if (empty($season)) {
            return 0;
        }

        $days = Carbon::now()->endOfDay()->diffInDays($season->stop_at_info->endOfDay(), false);
        if ($days <= 0) {
            return 0;
        }
        return $days;
    }

}
