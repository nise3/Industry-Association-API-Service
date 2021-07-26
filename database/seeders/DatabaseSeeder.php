<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\OrganizationUnitType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             OrganizationSeeder::class,
             OrganizationUnitTypeSeeder::class,
         ]);
    }
}
