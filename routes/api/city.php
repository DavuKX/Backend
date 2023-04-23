<?php

namespace api;

use App\Http\Controllers\CityController;
use Illuminate\Support\Facades\Route;

Route::apiResource('city', CityController::class)->middleware('auth:sanctum');
