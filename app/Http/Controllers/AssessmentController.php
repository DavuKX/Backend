<?php

namespace App\Http\Controllers;

use App\Http\Requests\Assessment\StoreAssessmentRequest;
use App\Http\Requests\Assessment\UpdateAssessmentRequest;
use App\Models\Assessment;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AssessmentController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Assessment::all(), HttpResponse::HTTP_OK);
    }

    public function store(StoreAssessmentRequest $request): JsonResponse
    {
        $validated = $request->validated();

        return response()->json(Assessment::create($validated), HttpResponse::HTTP_CREATED);
    }

    public function show(Assessment $assessment): JsonResponse
    {
        return response()->json($assessment, HttpResponse::HTTP_OK);
    }

    public function update(UpdateAssessmentRequest $request, Assessment $assessment): JsonResponse
    {
        $validated = $request->validated();

        $assessment->update($validated);

        return response()->json($assessment, HttpResponse::HTTP_OK);
    }

    public function destroy(Assessment $assessment): JsonResponse
    {
        $assessment->delete();

        return response()->json(null, 204);
    }
}
