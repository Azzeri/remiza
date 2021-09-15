<?php

namespace Database\Seeders;

use App\Models\Manufacturer;
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
        Manufacturer::create([
            'name' => 'OgnioChron',
        ]);

        Manufacturer::create([
            'name' => 'Calisia Vulcan',
        ]);

        Manufacturer::create([
            'name' => 'Flir',
        ]);

        Manufacturer::create([
            'name' => 'HONEYWELL',
        ]);

        Manufacturer::create([
            'name' => 'BIOMASK',
        ]);

        Manufacturer::create([
            'name' => 'OPTI-PRO',
        ]);

        Manufacturer::create([
            'name' => 'Aeris',
        ]);
    }
}