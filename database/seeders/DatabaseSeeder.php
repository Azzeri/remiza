<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('privileges')->insert([
            'name'=>'global admin'
        ]);

        DB::table('fire_brigade_units')->insert([
            'name'=>'OSP Krapkowice',
            'address'=>'Krapkowice 3, 48-100 Opole'
        ]);

        DB::table('users')->insert([
            'name'=>'admin',
            'surname'=>'admin',
            'email'=>'admin@admin.admin',
            'password'=>Hash::make('qwerty'),
            'privilege_id'=>1,
            'fire_brigade_unit_id'=>1
        ]);
    }
}
