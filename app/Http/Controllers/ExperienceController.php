<?php

namespace App\Http\Controllers;

use App\Http\Requests\Experience\StoreExperienceRequest;
use App\Http\Requests\Experience\UpdateExperienceRequest;
use App\Models\Experience;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class ExperienceController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Experience::all(), HttpResponse::HTTP_OK);
    }

    public function store(StoreExperienceRequest $request): JsonResponse
    {
        $validated = $request->validated();

        return response()->json(Experience::create($validated), HttpResponse::HTTP_CREATED);
    }

    public function show(Experience $experience): JsonResponse
    {
        return response()->json($experience, HttpResponse::HTTP_OK);
    }

    public function update(UpdateExperienceRequest $request, Experience $experience): JsonResponse
    {
        $validated = $request->validated();

        $experience->update($validated);

        return response()->json($experience, HttpResponse::HTTP_OK);
    }

    public function destroy(Experience $experience): JsonResponse
    {
        $experience->delete();

        return response()->json(null, 204);
    }
}
