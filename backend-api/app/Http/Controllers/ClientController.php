<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
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
     * @param ClientStoreRequest $request
     * @return ClientResource
     */
    public function store(ClientStoreRequest $request, ClientRepository $clientRepository) {
        $created = $clientRepository->create($request->only([
            'name',
            'gender',
            'marital_status',
            'date_of_birth',
        ]));

        return new ClientResource($created);
    }

    /**
     * Display the specified resource
     * @param \App\Models\Client
     * @return ClientResource | JsonResponse
     */
    public function show(Client $client) {
        return new ClientResource($client);
    }

    /**
     * Update the specified resource in storage
     *
     * @param ClientUpdateRequest $request
     * @param \App\Models\Client $client
     * @return ClientResource | JsonResponse
     */
    public function update(ClientUpdateRequest $request, Client $client, ClientRepository $clientRepository) {

        $client = $clientRepository->update($client, $request->only([
            'name',
            'gender',
            'marital_status',
            'date_of_birth',
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

    /**
     * Toggle the approval status of the specified resource.
     *
     * @param \App\Models\Client $client
     * @return ClientResource
     */
    public function approve(Client $client) {
        $newApprovalStatus = !$client->approval_status;

        $client->update([
            'approval_status' => $newApprovalStatus
        ]);

        return new ClientResource($client);
    }


}
