<?php

namespace Database\Seeders;

use App\Models\Screen;
use Illuminate\Database\Seeder;

class ScreenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Screen::create([
            'name' => 'Kimathi Street',
            'slug' => 'kimathi-street',
            'online' => true,
        ]);

        Screen::create([
            'name' => 'Haile Sellasie',
            'slug' => 'haile-sellasie',
            'online' => true,
        ]);
    }
}
