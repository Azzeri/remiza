<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::create([
            'name' => 'admin',
            'surname' => 'admin',
            'email' => 'admin@admin.admin',
            'password' => Hash::make('qwerty'),
            'privilege_id' => 1,
            'first_time_login' => false,
            'mfaverified' => true
        ]);

        User::create([
            'name' => 'Jan',
            'surname' => 'Nowak',
            'email' => 'jn@remiza.com',
            'password' => Hash::make('qwerty'),
            'privilege_id' => 4,
            'fire_brigade_unit_id' => 1,
            'first_time_login' => false,
            'mfaverified' => true
        ]);

        User::create([
            'name' => 'Adam',
            'surname' => 'Ciesla',
            'email' => 'ac@remiza.com',
            'password' => Hash::make('qwerty'),
            'privilege_id' => 2,
            'fire_brigade_unit_id' => 2,
            'first_time_login' => false,
            'mfaverified' => true
        ]);

        // DB::table('users')->insert([
        //     'name' => 'Arek',
        //     'surname' => 'Kowalski',
        //     'email' => 'ak@remiza.com',
        //     'password' => Hash::make('qwerty'),
        //     'privilege_id' => 3,
        //     'fire_brigade_unit_id' => 1
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Dawid',
        //     'surname' => 'Reka',
        //     'email' => 'dr@remiza.com',
        //     'password' => Hash::make('qwerty'),
        //     'privilege_id' => 3,
        //     'fire_brigade_unit_id' => 2
        // ]);
    }
}
