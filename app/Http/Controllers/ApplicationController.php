<?php

namespace App\Http\Controllers;

use App\Http\Requests\Application\StoreApplicationRequest;
use App\Http\Requests\Application\UpdateApplicationRequest;
use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class ApplicationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Application::all(), HttpResponse::HTTP_OK);
    }

    public function store(StoreApplicationRequest $request): JsonResponse
    {
        $validated = $request->validated();

        return response()->json(Application::create($validated), HttpResponse::HTTP_CREATED);
    }

    public function show(Application $application): JsonResponse
    {
        return response()->json($application, HttpResponse::HTTP_OK);
    }

    public function update(UpdateApplicationRequest $request, Application $application): JsonResponse
    {
        $validated = $request->validated();

        $application->update($validated);

        return response()->json($application, HttpResponse::HTTP_OK);
    }

    public function destroy(Application $application): JsonResponse
    {
        $application->delete();

        return response()->json(null, 204);
    }
}
