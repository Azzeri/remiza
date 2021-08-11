<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrivilegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('privileges')->insert([
            'name' => 'Administrator'
        ]);

        DB::table('privileges')->insert([
            'name' => 'Administrator jednostki'
        ]);

        DB::table('privileges')->insert([
            'name' => 'Koordynator sprzętu'
        ]);
    }
}
