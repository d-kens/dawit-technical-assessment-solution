<?php


namespace App\Repositories;

use App\Exceptions\GeneralJsonException;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class ClientRepository extends BaseRepository{

    public function create(array $attributes) {

        return DB::transaction(function () use ($attributes) {
            $created = Client::query()->create([
                'name' => data_get($attributes, 'name'),
                'gender' => data_get($attributes, 'gender'),
                'marital_status' => data_get($attributes, 'marital_status'),
                'date_of_birth' => data_get($attributes, 'date_of_birth'),
                'approval_status' => data_get($attributes, 'approval_status'),
            ]);

            // if(!$created) {
            //     throw new \Exception('Failed to create client');
            // }

            throw_if(!$created, GeneralJsonException::class, 'Failed to create client');

            return $created;
        });

    }



    /**
     * @param Client $client
     * @param array $attributes
     * @return mixed
     */
    public function update($client, array $attributes)
    {
        return DB::transaction(function () use($client, $attributes) {
            $updated = $client->update([
                'name' => data_get($attributes, 'name'),
                'gender' => data_get($attributes, 'gender'),
                'marital_status' => data_get($attributes, 'marital_status'),
                'date_of_birth' => data_get($attributes, 'date_of_birth'),
                'approval_status' => data_get($attributes, 'approval_status'),
            ]);

            // if(!$updated) {
            //     throw new \Exception('Failed to update client');
            // }

            throw_if(!$updated, GeneralJsonException::class, 'Failed to update client');

            return $client;
        });
    }

     /**
     * @param Client $client
     * @return mixed
     */
    public function forceDelete($client)
    {
        return DB::transaction(function () use($client) {
            $deleted = $client->forceDelete();

            // if(!$deleted) {
            //     throw new \Exception('Cannot delete client');
            // }

            throw_if(!$deleted, GeneralJsonException::class, 'Failed to delete client');

            return $deleted;
        });
    }

}
