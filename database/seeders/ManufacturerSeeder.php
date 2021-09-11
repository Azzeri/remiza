<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('manufacturers')->insert([
            'name' => 'OgnioChron',
        ]);

        DB::table('manufacturers')->insert([
            'name' => 'Calisia Vulcan',
        ]);

        DB::table('manufacturers')->insert([
            'name' => 'Flir',
        ]);
    }
}
