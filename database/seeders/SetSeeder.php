<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sets')->insert([
            'name' => 'set 1',
            'user_id' => 1,
            'fire_brigade_unit_id' => 1,
        ]);

        DB::table('sets')->insert([
            'name' => 'set 2',
            'user_id' => 1,
            'fire_brigade_unit_id' => 1,
        ]);

        DB::table('item_set')->insert([
            'set_id' => 1,
            'item_id' => 1,
        ]);

        DB::table('item_set')->insert([
            'set_id' => 1,
            'item_id' => 2,
        ]);

        DB::table('item_set')->insert([
            'set_id' => 2,
            'item_id' => 2,
        ]);
    }
}