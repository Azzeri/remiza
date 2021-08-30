<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            'expiry_date' => '2025-01-01',
            'item_database_id' => 1,
            'fire_brigade_unit_id' => 1,
        ]);

        DB::table('items')->insert([
            'expiry_date' => '2025-01-01',
            'item_database_id' => 3,
            'fire_brigade_unit_id' => 1,
        ]);
    }
}
