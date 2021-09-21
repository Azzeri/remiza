<?php

namespace Database\Seeders;

use App\Models\Cathegory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CathegorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cathegories')->insert([
            'name' => 'Hełmy',
        ]);

        DB::table('cathegories')->insert([
            'name' => 'Kamery Termowizyjne',
        ]);

        DB::table('cathegories')->insert([
            'name' => 'Latarki',
        ]);

        DB::table('cathegories')->insert([
            'name' => 'Gaśnice',
        ]);

        DB::table('cathegories')->insert([
            'name' => 'Gaśnice proszkowe',
            'cathegory_id' => 4
        ]);

        DB::table('cathegories')->insert([
            'name' => 'Gaśnice pianowe',
            'cathegory_id' => 4
        ]); 

        DB::table('cathegories')->insert([
            'name' => 'Gaśnice śniegowe',
            'cathegory_id' => 4
        ]);

        DB::table('cathegories')->insert([
            'name' => 'Gaśnice wodne',
            'cathegory_id' => 4
        ]); 

        Cathegory::create([//9
            'name' => 'Butle'
        ]);

        Cathegory::create([//10
            'name' => 'Butle kompozytowe',
            'cathegory_id' => 9,
            'fillable' => true
        ]);

        Cathegory::create([//11
            'name' => 'Butle stalowe',
            'cathegory_id' => 9,
            'fillable' => true
        ]);

        Cathegory::create([//12
            'name' => 'Maski',
        ]);

        Cathegory::create([//13
            'name' => 'Aparaty powietrzne',
        ]);

    }
}
