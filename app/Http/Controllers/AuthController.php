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
        return User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
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
