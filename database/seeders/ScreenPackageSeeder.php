<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\Screen;
use App\Models\ScreenPackage;
use Illuminate\Database\Seeder;

class ScreenPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gold = Package::where('slug', 'gold')->first();
        $silver = Package::where('slug', 'silver')->first();
        $platinum = Package::where('slug', 'platinum')->first();

        foreach(Screen::all() as $screen){
            ScreenPackage::create([
                'screen_id' => $screen->id,
                'package_id' => $gold->id,
                'type' => $gold->type,
                'price' => 12500,
            ]);

            ScreenPackage::create([
                'screen_id' => $screen->id,
                'package_id' => $silver->id,
                'type' => $silver->type,
                'price' => 11500,
            ]);

            ScreenPackage::create([
                'screen_id' => $screen->id,
                'package_id' => $platinum->id,
                'type' => $platinum->type,
                'price' => 13500,
            ]);
        }
    }
}
