<?php

namespace api;

use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

Route::apiResource('offers', OfferController::class);
Route::prefix('offers')->group(function () {
    Route::get('/user/{user}', [OfferController::class, 'getByUserId']);
});
