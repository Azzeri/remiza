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

        DB::table('cathegories')->insert([
            'name'=>'Hełm',
        ]);

        DB::table('cathegories')->insert([
            'name'=>'Butla',
        ]);

        DB::table('items')->insert([
            'name'=>'hełm 1',
            'expiry_date'=>'2025-01-01',
            'cathegory_id'=>1
        ]);

        DB::table('items')->insert([
            'name'=>'hełm 2',
            'expiry_date'=>'2025-01-01',
            'cathegory_id'=>1
        ]);

        DB::table('items')->insert([
            'name'=>'butla 1',
            'expiry_date'=>'2025-01-01',
            'cathegory_id'=>2
        ]);

        DB::table('items')->insert([
            'name'=>'butla 2',
            'expiry_date'=>'2025-01-01',
            'cathegory_id'=>2
        ]);

        DB::table('services')->insert([
            'name'=>'wymiana w hełmie 1',
            'perform_date'=>'2023-01-01',
            'days_to_next'=>365,
            'cathegory_id'=>1
        ]);

        DB::table('services')->insert([
            'name'=>'wymiana w hełmie 2',
            'perform_date'=>'2022-01-01',
            'days_to_next'=>165,
            'cathegory_id'=>1
        ]);

        DB::table('services')->insert([
            'name'=>'wymiana w butli 1',
            'perform_date'=>'2021-09-01',
            'days_to_next'=>30,
            'cathegory_id'=>2
        ]);

        DB::table('services')->insert([
            'name'=>'wymiana w butli 2',
            'perform_date'=>'2023-09-01',
            'days_to_next'=>320,
            'cathegory_id'=>2
        ]);
    }
}
