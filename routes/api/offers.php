<?php

namespace api;

use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

Route::apiResource('offers', OfferController::class)->middleware('auth:sanctum');
