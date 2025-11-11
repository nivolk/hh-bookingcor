<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Hunting\Infrastructure\Http\Controllers\BookingsStoreController;
use Modules\Hunting\Infrastructure\Http\Controllers\GuidesIndexController;

Route::middleware('api')->prefix('api')->group(function () {
    Route::get('/guides', GuidesIndexController::class);
    Route::post('/bookings', BookingsStoreController::class);
});
