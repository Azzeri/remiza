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
            'name' => 'Administrator'
        ]);

        DB::table('privileges')->insert([
            'name' => 'Administrator jednostki'
        ]);

        DB::table('privileges')->insert([
            'name' => 'Koordynator sprzętu'
        ]);

        DB::table('fire_brigade_units')->insert([
            'name' => 'OSP Krapkowice',
            'address' => 'Krapkowice 3, 48-100 Opole'
        ]);

        DB::table('fire_brigade_units')->insert([
            'name' => 'OSP Opole',
            'address' => 'Opole 3, 48-100 Opole'
        ]);

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

        DB::table('cathegories')->insert([
            'name' => 'Hełm',
        ]);

        DB::table('cathegories')->insert([
            'name' => 'Butla',
        ]);

        DB::table('item_databases')->insert([
            'name' => 'hełm 1',
            'cathegory_id' => 1
        ]);

        DB::table('item_databases')->insert([
            'name' => 'butla 1',
            'cathegory_id' => 2
        ]);

        DB::table('item_databases')->insert([
            'name' => 'hełm 2',
            'cathegory_id' => 1
        ]);

        DB::table('item_databases')->insert([
            'name' => 'butla 2',
            'cathegory_id' => 2
        ]);

        DB::table('item_databases')->insert([
            'name' => 'hełm 3',
            'cathegory_id' => 1
        ]);

        DB::table('item_databases')->insert([
            'name' => 'butla 3',
            'cathegory_id' => 2
        ]);

        DB::table('items')->insert([
            'expiry_date' => '2025-01-01',
            'item_database_id' => 1,
            'fire_brigade_unit_id' => 1
        ]);

        DB::table('items')->insert([
            'expiry_date' => '2025-01-01',
            'item_database_id' => 2,
            'fire_brigade_unit_id' => 1
        ]);

        DB::table('service_databases')->insert([
            'name' => 'wymiana w hełmie 1',
            'days_to_next' => 255,
            'cathegory_id' => 1
        ]);

        DB::table('service_databases')->insert([
            'name' => 'wymiana w butli 1',
            'days_to_next' => 123,
            'cathegory_id' => 2
        ]);

        DB::table('service_databases')->insert([
            'name' => 'wymiana w butli 2',
            'days_to_next' => 68,
            'cathegory_id' => 2
        ]);

        DB::table('services')->insert([
            'perform_date' => '2021-08-05',
            'item_id' => 2,
            'service_database_id' => 2
        ]);

        DB::table('services')->insert([
            'perform_date' => '2021-08-05',
            'item_id' => 2,
            'service_database_id' => 3
        ]);


    }
}
