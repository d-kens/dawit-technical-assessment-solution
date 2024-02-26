<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
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
        return new JsonResponse(['user' => $user], Response::HTTP_CREATED);
    }


    public function login(Request $request) {
        // validation
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

        // authentication attempt
        // unsuccessful authentication
        if (!Auth::attempt($request->only('email', 'password'))) {
            return new JsonResponse(['message' => 'Invalid Credentials'], Response::HTTP_UNAUTHORIZED);
        }

        // unsuccessful authentication
        $user = Auth::user();

        $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24); // jwt cookie

        // create a response with success message
        $response = new JsonResponse(['message' => 'success'], Response::HTTP_OK);

        // attach the jwt cookie to the response
        return $response->withCookie($cookie);
    }

    public function logout(Request $request) {
        // set the jwt cookie to null (remove cokkie) and with a negative expiration time
        $cookie = cookie('jwt', null, -1);

        $response = new JsonResponse(['message' => 'success'], Response::HTTP_OK);

        return $response->withCookie($cookie);
    }
}
