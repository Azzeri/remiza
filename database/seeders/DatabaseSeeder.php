<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PrivilegeSeeder::class,
            FireBrigadeUnitSeeder::class,
            UserSeeder::class,
            CathegorySeeder::class,
            SubcathegorySeeder::class,
            ManufacturerSeeder::class,
            ItemDatabaseSeeder::class,
            ItemSeeder::class,
            ServiceDatabaseSeeder::class,
            ServiceSeeder::class,
        ]);
    }
}
