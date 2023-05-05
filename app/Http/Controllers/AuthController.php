<?php

namespace App\Http\Controllers;

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
     * @return User
     */
    public function register(Request $request): User
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'username'   => 'required|string|max:255|unique:users',
            'city_id'    => 'required|integer|exists:cities,id',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:8|confirmed',
        ]);

        return User::create([
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'username'   => $request->input('username'),
            'city_id'    => $request->input('city_id'),
            'email'      => $request->input('email'),
            'password'   => Hash::make($request->input('password')),
        ]);
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

        $user = Auth::user();

        $token = $user->createToken('session')->plainTextToken;
        $cookie = \cookie('jwt', $token, 60 * 24);

        return response([
            'message' => 'Login success'
        ])->withCookie($cookie);
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
