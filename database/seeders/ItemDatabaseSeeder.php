<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('item_databases')->insert([
            'name' => 'hełm 1',
            'cathegory_id' => 1,
            'manufacturer_id' => 1
        ]);

        DB::table('item_databases')->insert([
            'name' => 'hełm 2',
            'cathegory_id' => 1,
            'manufacturer_id' => 1
        ]);

        DB::table('item_databases')->insert([
            'name' => 'butla 1',
            'cathegory_id' => 2,
            'manufacturer_id' => 1
        ]);

        DB::table('item_databases')->insert([
            'name' => 'butla 2',
            'cathegory_id' => 2,
            'manufacturer_id' => 1
        ]);
    }
}