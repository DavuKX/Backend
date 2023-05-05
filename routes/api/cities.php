<?php

namespace api;

use App\Http\Controllers\CityController;
use Illuminate\Support\Facades\Route;

Route::apiResource('cities', CityController::class)->middleware('auth:sanctum');
