<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Rol;
use App\Models\State;
use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class AuthController extends Controller
{
    /**
     * @return string
     */
    public function user(): string
    {
        return Auth::user();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\Response|Application|ResponseFactory
     */
    public function register(Request $request): \Illuminate\Contracts\Foundation\Application|ResponseFactory|Application|\Illuminate\Http\Response
    {
        $city = City::where('name', $request->input('city'))->first();

        if (!$city)
        {
            $state = State::where('name', $request->input('department'))->first();

            if (!$state)
            {
                $country = Country::where('name', 'Colombia')->first();

                $state = State::create([
                    'name' => $request->input('department'),
                    'country_id' => $country->id
                ]);
            }

            $city = City::create([
                'name'     => $request->input('city'),
                'state_id' => $state->id
            ]);
        }

        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'username'   => $request->input('username'),
            'city_id'    => $city->id,
            'email'      => $request->input('email'),
            'password'   => Hash::make($request->input('password')),
        ]);

        if ($request->input('rol') === null)
        {
            $rol = Rol::where('name', 'Empleado')->first();
            $user->roles()->attach($rol);
        }
        else
        {
            $rol = Rol::where('name', $request->input('rol'))->first();
            $user->roles()->attach($rol);
        }

        return response([
            'message' => 'User created'
        ], Response::HTTP_CREATED);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|ResponseFactory|Application|\Illuminate\Http\Response
     */
    public function login(Request $request): Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        if(!Auth::attempt($request->only('email', 'password')))
        {
            return response([
                'message' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user()->load('roles');

        $token = $user->createToken('session')->plainTextToken;
        $cookie = \cookie('jwt', $token, 60 * 24);

        return response([
            'message' => 'Login success',
            'data' => $user,
        ])
        ->withCookie($cookie);
    }


    /**
     * @return Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
     */
    public function logout(): Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'Log out successful'
        ])->withCookie($cookie);
    }
}
