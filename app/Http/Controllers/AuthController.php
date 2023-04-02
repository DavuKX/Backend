<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function user(): string
    {
        return 'Authenticated user';
    }
}
