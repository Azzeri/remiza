<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubcathegorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subcathegories')->insert([
            'name' => 'Butla podk 1',
            'cathegory_id' => 2
        ]);

        DB::table('subcathegories')->insert([
            'name' => 'Butla podk2',
            'cathegory_id' => 2
        ]);

        DB::table('subcathegories')->insert([
            'name' => 'Hełm podk 1',
            'cathegory_id' => 1
        ]);

        DB::table('subcathegories')->insert([
            'name' => 'Hełm podk2',
            'cathegory_id' => 1
        ]);
    }
}
