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
            'name' => 'Hełm',
        ]);

        DB::table('cathegories')->insert([
            'name' => 'Butla',
            'cathegory_id' => 1
        ]);
    }
}
