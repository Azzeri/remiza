<?php

namespace Database\Seeders;

use App\Models\FireBrigadeUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FireBrigadeUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FireBrigadeUnit::create([
            'name' => 'OSP Krapkowice',
            'address' => 'Krapkowice 3, 48-100 Opole'
        ]);
        
        FireBrigadeUnit::create([
            'name' => 'OSP Opole',
            'address' => 'Opole 3, 48-100 Opole',
            'superior_unit_id' => 1
        ]);

        FireBrigadeUnit::create([
            'name' => 'OSP Sucha Kamienica',
            'address' => 'Sucha Kamienica 3, 48-100 Głuchołazy'
        ]);
    }
}
