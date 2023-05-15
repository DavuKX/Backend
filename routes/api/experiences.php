<?php

namespace api;

use App\Http\Controllers\ExperienceController;
use Illuminate\Support\Facades\Route;

Route::apiResource('experiences', ExperienceController::class)->middleware('auth:sanctum');
