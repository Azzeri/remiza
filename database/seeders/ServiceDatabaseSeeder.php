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
            'name' => 'Wymiana w hełmie 1',
            'days_to_next' => 68,
            'cathegory_id' => 1,
        ]);

        DB::table('service_databases')->insert([
            'name' => 'Wymiana w hełmie 2',
            'days_to_next' => 354,
            'cathegory_id' => 1,
        ]);

        DB::table('service_databases')->insert([
            'name' => 'Wymiana w kamerze 1',
            'days_to_next' => 123,
            'cathegory_id' => 2,
        ]);

        DB::table('service_databases')->insert([
            'name' => 'Wymiana w kamerze 2',
            'days_to_next' => 3456,
            'cathegory_id' => 2,
        ]);

        DB::table('service_databases')->insert([
            'name' => 'Wymiana w latarce 1',
            'days_to_next' => 30,
            'cathegory_id' => 5,
        ]);

        DB::table('service_databases')->insert([
            'name' => 'Wymiana w toporku 1',
            'days_to_next' => 76,
            'cathegory_id' => 7,
        ]);

        DB::table('service_databases')->insert([
            'name' => 'Wymiana w toporku 2',
            'days_to_next' => 99,
            'cathegory_id' => 7,
        ]);   
    }
}
