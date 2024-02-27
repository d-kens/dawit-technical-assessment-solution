<?php

namespace App\Http\Controllers;


use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ClientRepository;
use App\Http\Resources\ClientResource;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\ResourceCollection;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @return ResourceCollection
     */
    public function index(Request $request) {
        // $clients = Client::query()->paginate($request->page_size ?? 10);
        $clients = Client::query()->get();


        return ClientResource::collection($clients);
    }


    /**
     * Store a newly created resoource in storage
     *
     * @param Request $request
     * @return ClientResource | JsonResponse
     */
    public function store(Request $request, ClientRepository $clientRepository) {
        // validate data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'gender' => 'required|string|in:male,female', // Assuming 'gender' can only be 'Male' or 'Female'
            'marital_status' => 'required|string',
            'date_of_birth' => 'required|date',
        ]);

        if ($validator->fails()) {
            return new JsonResponse(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // create client
        $created = $clientRepository->create($request->only([
            'name',
            'gender',
            'marital_status',
            'date_of_birth',
        ]));

        return (new ClientResource($created))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource
     * @param \App\Models\Client
     * @return ClientResource | JsonResponse
     */
    public function show(Client $client) {
        return (new ClientResource($client))->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage
     *
     * @param Request $request
     * @param \App\Models\Client $client
     * @return ClientResource | JsonResponse
     */
    public function update(Request $request, Client $client, ClientRepository $clientRepository) {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string',
            'gender' => 'sometimes|string|in:male,female', // Assuming 'gender' can only be 'Male' or 'Female'
            'marital_status' => 'sometimes|string',
            'date_of_birth' => 'sometimes|date',
        ]);

        if ($validator->fails()) {
            return new JsonResponse(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $client = $clientRepository->update($client, $request->only([
            'name',
            'gender',
            'marital_status',
            'date_of_birth',
        ]));

        return (new ClientResource($client))->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage
     *
     *  @param \App\Models\Client $client
     *  @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Client $client, ClientRepository $clientRepository) {
        $client = $clientRepository->forceDelete($client);

        return new JsonResponse(['data' => 'success'], Response::HTTP_OK);
    }

    /**
     * Toggle the approval status of the specified resource.
     *
     * @param \App\Models\Client $client
     * @return ClientResource | JsonResponse
     */
    public function approve(Client $client) {
        $newApprovalStatus = !$client->approval_status;

        $client->update([
            'approval_status' => $newApprovalStatus
        ]);

        return (new ClientResource($client))->response()->setStatusCode(Response::HTTP_OK);
    }

}
