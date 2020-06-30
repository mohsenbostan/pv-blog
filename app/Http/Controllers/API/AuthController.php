<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);

        resolve(UserRepository::class)->store($request->name, $request->email, $request->password);

        return response()->json([
            'message' => 'user created successfully'
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only(['email', 'password']))) {
            return \response()->json([
                'message' => 'user logged in successfully'
            ], Response::HTTP_OK);
        }

        return \response()->json([
            'message' => 'wrong credentials'
        ], Response::HTTP_EXPECTATION_FAILED);
    }

    public function logout()
    {
        Auth::logout();

        return \response()->json([
            'message' => 'user logged oy successfully'
        ], Response::HTTP_OK);
    }

    public function user(Request $request)
    {
        return \response()->json($request->user(), Response::HTTP_OK);
    }
}
