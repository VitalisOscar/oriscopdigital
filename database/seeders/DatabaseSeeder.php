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
        // $this->call(CategorySeeder::class);
        // $this->call(PackageSeeder::class);
        // $this->call(ScreenSeeder::class);
        // $this->call(ScreenPackageSeeder::class);
        $this->call(StaffSeeder::class);
    }
}
