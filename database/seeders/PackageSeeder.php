<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Package::create([
            'name' => 'Gold',
            'slug' => 'gold',
            'from' => 6,
            'to' => 9,
            'clients' => 15,
            'loops' => 50,
            'type' => Package::TYPE_PEAK
        ]);

        Package::create([
            'name' => 'Silver',
            'slug' => 'silver',
            'from' => 9,
            'to' => 16,
            'clients' => 15,
            'loops' => 50,
            'type' => Package::TYPE_OFF_PEAK
        ]);

        Package::create([
            'name' => 'Platinum',
            'slug' => 'platinum',
            'from' => 16,
            'to' => 21,
            'clients' => 15,
            'loops' => 50,
            'type' => Package::TYPE_PEAK
        ]);
    }
}
