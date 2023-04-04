<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function user(): string
    {
        return Auth::user();
    }

    public function register(Request $request): User
    {
        return User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
    }

    public function login(Request $request)
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

    public function logout()
    {
        $cookie = \Illuminate\Support\Facades\Cookie::forget('jwt');

        return response([
            'message' => 'Log out successful'
        ])->withCookie($cookie);
    }
}
