<?php

namespace App\Http\Controllers;

use App\Http\Requests\Offer\StoreOfferRequest;
use App\Http\Requests\Offer\UpdateOfferRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Offer;
use App\Models\State;
use App\Http\Controllers\Helpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class OfferController extends Controller
{
    public function index(): JsonResponse
    {
        $offers = Offer::all()->load( 'city');
        return response()->json($offers, HttpResponse::HTTP_OK);
    }

    public function store(StoreOfferRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $city = Helpers::getOrCreateCity($validated['city'], $validated['departament']);
        $data = array_merge($validated, [
            'user_id' => 11,
            'city_id' => $city->id,
        ]);
        $offer = Offer::create($data);

        if (!$offer)
        {
            return response()->json(['message' => 'Error creating the offer'], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($offer->load('city'), HttpResponse::HTTP_CREATED);
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

