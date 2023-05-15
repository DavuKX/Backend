<?php

namespace api;

use App\Http\Controllers\AssessmentController;
use Illuminate\Support\Facades\Route;

Route::apiResource('assessments', AssessmentController::class)->middleware('auth:sanctum');
