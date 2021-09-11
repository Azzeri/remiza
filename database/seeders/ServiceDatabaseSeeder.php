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
            'name' => 'Serwis kamery termowizyjnej 1',
            'days_to_next' => 30,
            'cathegory_id' => 2,
        ]);

        DB::table('service_databases')->insert([
            'name' => 'Serwis kamery termowizyjnej 2',
            'days_to_next' => 14,
            'cathegory_id' => 2,
        ]);

        DB::table('service_databases')->insert([
            'name' => 'Serwis gaśnicy proszkowej',
            'days_to_next' => 30,
            'cathegory_id' => 5,
        ]);

        DB::table('service_databases')->insert([
            'name' => 'Serwis gaśnicy pianowej',
            'days_to_next' => 60,
            'cathegory_id' => 6,
        ]);

        DB::table('service_databases')->insert([
            'name' => 'Serwis gaśnicy śniegowej',
            'days_to_next' => 30,
            'cathegory_id' => 7,
        ]);

        DB::table('service_databases')->insert([
            'name' => 'Serwis gaśnicy wodnej',
            'days_to_next' => 60,
            'cathegory_id' => 8,
        ]);
    }
}
