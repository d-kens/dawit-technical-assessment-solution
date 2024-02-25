<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\ClientResource;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Resources\Json\ResourceCollection;



class UserController extends Controller
{

    /**
     * Display a listing of the resource
     *
     * @return ResourceCollection
     */

     public function index(Request $request) {
        $users = User::query()->paginate($request->page_size ?? 10);

        return UserResource::collection($users);
    }


    /**
     * Store a newly created resoource in storage
     *
     * @param \Illuminate\Http\Request
     * @return UserResource
     */
    public function store(Request $request, UserRepository $userRepository) {
        $created = $userRepository->create($request->only([
            'name',
            'email',
            'password'
        ]));

        return new UserResource($created);
    }

    /**
     * Display the specified resource
     * @param \App\Models\User
     * @return UserResource
     */
    public function show(User $user) {
        return new UserResource($user);
    }


    /**
     * Update the specified resource in storage
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return UserResource | JsonResponse
     */
    public function update(Request $request, User $user) {
        $updated = $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ?? $user->password,
        ]);

        if(!$updated) {
            return new JsonResponse([
                'errors' => [
                    'Failed to update model.'
                ]
            ], 400);
        }

        return new UserResource($user);
    }


    /**
     * Remove the specified resource from storage
     *
     *  @param \App\Models\User $user
     *  @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user) {
        $deleted = $user->forceDelete();

        if(!$deleted) {
            return new JsonResponse([
                'errors' => [
                    'Could not delete resource.'
                ]
            ], 400);
        }

        return new JsonResponse([
            'data' => 'success'
        ]);
    }

}
