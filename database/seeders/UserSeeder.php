<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'surname' => 'admin',
            'email' => 'admin@admin.admin',
            'password' => Hash::make('qwerty'),
            'privilege_id' => 1,
            'fire_brigade_unit_id' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'Jan',
            'surname' => 'Nowak',
            'email' => 'jn@remiza.com',
            'password' => Hash::make('qwerty'),
            'privilege_id' => 2,
            'fire_brigade_unit_id' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'Arek',
            'surname' => 'Kowalski',
            'email' => 'ak@remiza.com',
            'password' => Hash::make('qwerty'),
            'privilege_id' => 3,
            'fire_brigade_unit_id' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'Adam',
            'surname' => 'Ciesla',
            'email' => 'ac@remiza.com',
            'password' => Hash::make('qwerty'),
            'privilege_id' => 2,
            'fire_brigade_unit_id' => 2
        ]);

        DB::table('users')->insert([
            'name' => 'Dawid',
            'surname' => 'Reka',
            'email' => 'dr@remiza.com',
            'password' => Hash::make('qwerty'),
            'privilege_id' => 3,
            'fire_brigade_unit_id' => 2
        ]);
    }
}
