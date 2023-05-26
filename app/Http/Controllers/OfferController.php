<?php

namespace App\Http\Controllers;

use App\Http\Requests\Offer\StoreOfferRequest;
use App\Http\Requests\Offer\UpdateOfferRequest;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class OfferController extends Controller
{
    public function index(): JsonResponse
    {
        $offers = Offer::all()->load( 'city');
        return response()->json($offers, HttpResponse::HTTP_OK);
    }

    public function getByUserId(User $user): JsonResponse
    {
        $offers = Offer::where('user_id', $user->id)->get()->load('city');
        return response()->json($offers, HttpResponse::HTTP_OK);
    }

    public function store(StoreOfferRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $city = Helpers::getOrCreateCity($validated['city'], $validated['departament']);
        $data = array_merge($validated, [
            'user_id' => User::all()->first()->id,
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
        $city = Helpers::getOrCreateCity($validated['city'], $validated['departament']);
        $validated['city_id'] = $city->id;

        $offer = $offer->update($validated);

        if (!$offer)
        {
            return response()->json(['message' => 'Error updating the offer'], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($offer, HttpResponse::HTTP_OK);
    }

    public function destroy(Offer $offer): JsonResponse
    {
        $offer->delete();

        return response()->json(null, 204);
    }
}

