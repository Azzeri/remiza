<?php

namespace Database\Seeders;

use App\Models\ItemDatabase;
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
        ItemDatabase::create([
            'stencil_name'=> 'Butle kompozytowe',
            'construction_number'=> true,
            'inventory_number'=> true,
            'date_expiry'=> true,
            'date_legalisation'=> true,
            'manufacturer' => true,
            'cathegory_id' => 10
        ]);

        ItemDatabase::create([
            'stencil_name'=> 'Butle stalowe',
            'construction_number'=> true,
            'identification_number'=> true,
            'date_legalisation_due'=> true,
            'vehicle'=> true,
            'cathegory_id' => 11
        ]);

        ItemDatabase::create([
            'stencil_name'=> 'Maski',
            'construction_number'=> true,
            'identification_number'=> true,
            'date_production'=> true,
            'manufacturer' => true,
            'cathegory_id' => 12
        ]);

        ItemDatabase::create([
            'stencil_name'=> 'Aparaty powietrzne',
            'construction_number'=> true,
            'identification_number'=> true,
            'date_legalisation_due'=> true,
            'date_production'=> true,
            'manufacturer'=> true,
            'vehicle'=> true,
            'cathegory_id' => 13
        ]);

        ItemDatabase::create([
            'stencil_name'=> 'One To Rule Them All',
            'construction_number'=> true,
            'identification_number'=> true,
            'date_legalisation_due'=> true,
            'date_production'=> true,
            'manufacturer'=> true,
            'vehicle'=> true,
            'cathegory_id' => 13,
            'inventory_number'=> true,
            'date_expiry'=> true,
            'date_legalisation'=> true,
            'name'=> true,
        ]);

        ItemDatabase::create([
            'stencil_name'=> 'Kamera termowizyjna',
            'construction_number'=> true,
            'inventory_number'=> true,
            'date_expiry'=> true,
            'date_production'=> true,
            'date_legalisation'=> true,
            'manufacturer' => true,
            'cathegory_id' => 2
        ]);

        // DB::table('item_databases')->insert([
        //     'name' => 'He??m Stra??acki Bia??y',
        //     'cathegory_id' => 1,
        //     'manufacturer_id' => 2
        // ]);

        // DB::table('item_databases')->insert([
        //     'name' => 'He??m Stra??acki Czerwony',
        //     'cathegory_id' => 1,
        //     'manufacturer_id' => 2
        // ]);

        // DB::table('item_databases')->insert([
        //     'name' => 'Kamera termowizyjna K2',
        //     'cathegory_id' => 2,
        //     'manufacturer_id' => 3
        // ]);

        // DB::table('item_databases')->insert([
        //     'name' => 'Kamera termowizyjna K33',
        //     'cathegory_id' => 2,
        //     'manufacturer_id' => 3
        // ]);

        // DB::table('item_databases')->insert([
        //     'name' => 'Ga??nica proszkowa 6kg',
        //     'cathegory_id' => 5,
        //     'manufacturer_id' => 1
        // ]);

        // DB::table('item_databases')->insert([
        //     'name' => 'Ga??nica proszkowa 12kg',
        //     'cathegory_id' => 5,
        //     'manufacturer_id' => 1
        // ]);

        // DB::table('item_databases')->insert([
        //     'name' => 'Ga??nica pianowa 6kg',
        //     'cathegory_id' => 6,
        //     'manufacturer_id' => 1
        // ]);

        // DB::table('item_databases')->insert([
        //     'name' => 'Ga??nica ??niegowa 5kg',
        //     'cathegory_id' => 7,
        //     'manufacturer_id' => 1
        // ]);

        // DB::table('item_databases')->insert([
        //     'name' => 'Ga??nica wodna-mg??owa 6l',
        //     'cathegory_id' => 8,
        //     'manufacturer_id' => 1
        // ]);
    }
}
