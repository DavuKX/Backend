<?php

namespace App\Http\Controllers;

use App\Http\Requests\Offer\StoreOfferRequest;
use App\Http\Requests\Offer\UpdateOfferRequest;
use App\Models\Offer;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class OfferController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Offer::all(), HttpResponse::HTTP_OK);
    }

    public function store(StoreOfferRequest $request): JsonResponse
    {
        $validated = $request->validated();

        return response()->json(Offer::create($validated), HttpResponse::HTTP_CREATED);
    }

    public function show(Offer $offer): JsonResponse
    {
        return response()->json($offer, HttpResponse::HTTP_OK);
    }

    public function update(UpdateOfferRequest $request, Offer $offer): JsonResponse
    {
        $validated = $request->validated();

        $offer->update($validated);

        return response()->json($offer, HttpResponse::HTTP_OK);
    }

    public function destroy(Offer $offer): JsonResponse
    {
        $offer->delete();

        return response()->json(null, 204);
    }
}

