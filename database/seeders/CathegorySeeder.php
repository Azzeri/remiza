<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CathegorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cathegories')->insert([
            'name' => 'Hełmy',
        ]);

        DB::table('cathegories')->insert([
            'name' => 'Kamery Termowizyjne',
        ]);

        DB::table('cathegories')->insert([
            'name' => 'Latarki',
        ]);

        DB::table('cathegories')->insert([
            'name' => 'Gaśnice',
        ]);

        DB::table('cathegories')->insert([
            'name' => 'Gaśnice proszkowe',
            'cathegory_id' => 4
        ]);

        DB::table('cathegories')->insert([
            'name' => 'Gaśnice pianowe',
            'cathegory_id' => 4
        ]); 

        DB::table('cathegories')->insert([
            'name' => 'Gaśnice śniegowe',
            'cathegory_id' => 4
        ]);

        DB::table('cathegories')->insert([
            'name' => 'Gaśnice wodne',
            'cathegory_id' => 4
        ]); 

    }
}
