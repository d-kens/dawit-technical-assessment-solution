<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @return ResourceCollection
     */
    public function index(Request $request) {
        $clients = Client::query()->paginate($request->page_size ?? 10);

        return ClientResource::collection($clients);
    }


    /**
     * Store a newly created resoource in storage
     *
     * @param \Illuminate\Http\Request
     * @return ClientResource
     */
    public function store(Request $request, ClientRepository $clientRepository) {
        $created = $clientRepository->create($request->only([
            'name',
            'gender',
            'marital_status',
            'date_of_birth',
            'approval_status' // ! This should be removed
        ]));

        return new ClientResource($created);
    }

    /**
     * Display the specified resource
     * @param \App\Models\Client
     * @return ClientResource
     */
    public function show(Client $client) {

        return new ClientResource($client);
    }

    /**
     * Update the specified resource in storage
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Client $client
     * @return ClientResource | JsonResponse
     */
    public function update(Request $request, Client $client, ClientRepository $clientRepository) {

        $client = $clientRepository->update($client, $request->only([
            'name',
            'gender',
            'marital_status',
            'date_of_birth',
            'approval_status' // ! This should be removed
        ]));

        return new ClientResource($client);
    }

    /**
     * Remove the specified resource from storage
     *
     *  @param \App\Models\Client $client
     *  @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Client $client, ClientRepository $clientRepository) {
        $client = $clientRepository->forceDelete($client);
        return new JsonResponse([
            'data' => 'success'
        ]);
    }


}
