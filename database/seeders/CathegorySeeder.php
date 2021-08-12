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
            'name' => 'Sprzęt pomocniczy',
        ]);

        DB::table('cathegories')->insert([
            'name' => 'Latarki Streamlight',
            'cathegory_id' => 3
        ]);

        DB::table('cathegories')->insert([
            'name' => 'Latarki Nightstick',
            'cathegory_id' => 3
        ]); 

        DB::table('cathegories')->insert([
            'name' => 'Hydronetki',
            'cathegory_id' => 4
        ]);

        DB::table('cathegories')->insert([
            'name' => 'Toporki strażackie',
            'cathegory_id' => 4
        ]); 

        DB::table('cathegories')->insert([
            'name' => 'Bosaki strażackie',
            'cathegory_id' => 4
        ]); 

    }
}
