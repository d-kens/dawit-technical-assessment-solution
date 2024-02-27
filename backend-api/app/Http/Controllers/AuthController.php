<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return new JsonResponse(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // create user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);


        // Return success response with status code 201
        return new JsonResponse([
            'user' => $user,
            'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return new JsonResponse(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'message'=> 'Invalid Credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }


        $user = User::where('email', $request->email)->first();

        return new JsonResponse([
            'user' => $user,
            'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken
        ], Response::HTTP_OK);

    }


    public function logout() {
        Auth::user()->currentAccessToken()->delete();

        return new JsonResponse([
            'message' => 'you have successfuly been logged out'
        ], Response::HTTP_OK);
    }
}
