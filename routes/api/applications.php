<?php

namespace api;

use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;

Route::apiResource('applications', ApplicationController::class)->middleware('auth:sanctum');
