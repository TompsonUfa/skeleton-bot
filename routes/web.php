<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramController;

Route::any('telegram/{secret}', [TelegramController::class, 'index']);


