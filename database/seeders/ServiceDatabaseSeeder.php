<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service_databases')->insert([
            'name' => 'wymiana w hełmie 1',
            'days_to_next' => 255,
            'subcathegory_id' => 1
        ]);

        DB::table('service_databases')->insert([
            'name' => 'wymiana w butli 1',
            'days_to_next' => 123,
            'subcathegory_id' => 3
        ]);

        DB::table('service_databases')->insert([
            'name' => 'wymiana w butli 2',
            'days_to_next' => 68,
            'subcathegory_id' => 3
        ]);

    }
}
