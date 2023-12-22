<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Services\StatisticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function __construct()
    {
        $this->middleware('simple.auth');
    }

    public function dashboardStats(): JsonResponse
    {
        $service = new StatisticsService();
        $data = $service->dashboardData();

        return response()->json($data);
    }

    public function userLanguages()
    {
        $service = new StatisticsService();
        $languages = $service->userLanguages();

        return response()->json($languages);
    }

    public function userGrowth(Request $request)
    {
        $service = new StatisticsService();
        $result = $service->userGrowth($request->all());

        return response()->json($result);
    }

    public function gameLaunch(Request $request)
    {
        $service = new StatisticsService();
        $result = $service->gameLaunch($request->all());

        return response()->json($result);
    }
}
