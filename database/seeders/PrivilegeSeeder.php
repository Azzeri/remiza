<?php

namespace Database\Seeders;

use App\Models\Privilege;
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
        Privilege::create(['name' => 'Administrator']);
        Privilege::create(['name' => 'Administrator jednostki podrzędnej']);
        Privilege::create(['name' => 'Koordynator sprzętu']);
        Privilege::create(['name' => 'Administrator jednostki nadrzędnej']);
    }
}
