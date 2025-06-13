<?php

namespace Branzia\Tax\Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Branzia\Shop\Models\Warehouse;
class WarehouseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Warehouse::firstOrCreate(
            ['name' => 'Default Warehouse'],
            ['location' => 'Main Store Location']
        );
    }
}
