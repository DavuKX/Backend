<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Foundation\Application|\Illuminate\Http\Response|Application|ResponseFactory
    {
        return response(User::all(), Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): \Illuminate\Foundation\Application|\Illuminate\Http\Response|Application|ResponseFactory
    {
        return response($user, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): \Illuminate\Foundation\Application|\Illuminate\Http\Response|Application|ResponseFactory
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);

        $user->update($data);

        return response($user, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): \Illuminate\Foundation\Application|\Illuminate\Http\Response|Application|ResponseFactory
    {
        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
