<?php

namespace App\Http\Controllers;

use App\Services\Telegram\Api\ServiceScreen;
use App\Services\Telegram\Api\UpdateApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramController
{
    public function index(Request $request, $secret)
    {
//        Log::info(json_encode($request->all()));
//        return response()->json([]);

        if ($secret !== env('TELEGRAM_SECRET')) {
            return response()->json([]);
        }

        try {
            $service = new ServiceScreen();
            $service->setPlayload(UpdateApi::fromResponse($request->all()));
            $service->run();
        } catch (\Exception $e) {
            Log::info(__CLASS__ . ' ' . __METHOD__);
            Log::error(json_encode($request->all()));
            Log::error(json_encode($e->getTrace()));
            Log::error($e->getMessage());
            return response()->json([]);
        }

        return response()->json([]);

    }
}
