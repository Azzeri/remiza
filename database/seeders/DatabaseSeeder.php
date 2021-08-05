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
            'name'=>'Administrator'
        ]);

        DB::table('privileges')->insert([
            'name'=>'Administrator jednostki'
        ]);

        DB::table('privileges')->insert([
            'name'=>'Koordynator sprzętu'
        ]);

        DB::table('fire_brigade_units')->insert([
            'name'=>'OSP Krapkowice',
            'address'=>'Krapkowice 3, 48-100 Opole'
        ]);

        DB::table('fire_brigade_units')->insert([
            'name'=>'OSP Opole',
            'address'=>'Opole 3, 48-100 Opole'
        ]);

        DB::table('users')->insert([
            'name'=>'admin',
            'surname'=>'admin',
            'email'=>'admin@admin.admin',
            'password'=>Hash::make('qwerty'),
            'privilege_id'=>1,
            'fire_brigade_unit_id'=>1
        ]);

        DB::table('users')->insert([
            'name'=>'Jan',
            'surname'=>'Nowak',
            'email'=>'jn@remiza.com',
            'password'=>Hash::make('qwerty'),
            'privilege_id'=>2,
            'fire_brigade_unit_id'=>1
        ]);

        DB::table('users')->insert([
            'name'=>'Arek',
            'surname'=>'Kowalski',
            'email'=>'ak@remiza.com',
            'password'=>Hash::make('qwerty'),
            'privilege_id'=>3,
            'fire_brigade_unit_id'=>1
        ]);

        DB::table('users')->insert([
            'name'=>'Adam',
            'surname'=>'Ciesla',
            'email'=>'ac@remiza.com',
            'password'=>Hash::make('qwerty'),
            'privilege_id'=>2,
            'fire_brigade_unit_id'=>2
        ]);

        DB::table('users')->insert([
            'name'=>'Dawid',
            'surname'=>'Reka',
            'email'=>'dr@remiza.com',
            'password'=>Hash::make('qwerty'),
            'privilege_id'=>3,
            'fire_brigade_unit_id'=>2
        ]);
    }
}