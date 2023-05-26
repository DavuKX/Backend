<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;

class Helpers
{
    public static function getOrCreateCity(string $cityName, string $departmentName = null)
    {
        $city = City::where('name', $cityName)->first();

        if (!$city)
        {
            $state = State::where('name', $departmentName)->first();

            if (!$state)
            {
                $country = Country::where('name', 'Colombia')->first();

                $state = State::create([
                    'name' => $departmentName,
                    'country_id' => $country->id
                ]);
            }

            $city = City::create([
                'name'     => $cityName,
                'state_id' => $state->id
            ]);
        }

        return $city;
    }
}
