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
            'name' => 'Hełm Strażacki Biały',
            'cathegory_id' => 1,
            'manufacturer_id' => 2
        ]);

        DB::table('item_databases')->insert([
            'name' => 'Hełm Strażacki Czerwony',
            'cathegory_id' => 1,
            'manufacturer_id' => 2
        ]);

        DB::table('item_databases')->insert([
            'name' => 'Kamera termowizyjna K2',
            'cathegory_id' => 2,
            'manufacturer_id' => 3
        ]);

        DB::table('item_databases')->insert([
            'name' => 'Kamera termowizyjna K33',
            'cathegory_id' => 2,
            'manufacturer_id' => 3
        ]);

        DB::table('item_databases')->insert([
            'name' => 'Gaśnica proszkowa 6kg',
            'cathegory_id' => 5,
            'manufacturer_id' => 1
        ]);

        DB::table('item_databases')->insert([
            'name' => 'Gaśnica proszkowa 12kg',
            'cathegory_id' => 5,
            'manufacturer_id' => 1
        ]);

        DB::table('item_databases')->insert([
            'name' => 'Gaśnica pianowa 6kg',
            'cathegory_id' => 6,
            'manufacturer_id' => 1
        ]);

        DB::table('item_databases')->insert([
            'name' => 'Gaśnica śniegowa 5kg',
            'cathegory_id' => 7,
            'manufacturer_id' => 1
        ]);

        DB::table('item_databases')->insert([
            'name' => 'Gaśnica wodna-mgłowa 6l',
            'cathegory_id' => 8,
            'manufacturer_id' => 1
        ]);
    }
}
