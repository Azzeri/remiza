<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([
            'perform_date' => '2021-08-07',
            'item_id' => 2,
            'service_database_id' => 2
        ]);

        DB::table('services')->insert([
            'perform_date' => '2021-08-07',
            'item_id' => 2,
            'service_database_id' => 3
        ]);
    }
}
