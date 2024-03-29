<?php

namespace Database\Seeders;

use App\Models\Client;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKeys();

        $this->truncate('clients');

        Client::factory(10)->create();

        $this->enableForeignKeys();
    }
}
