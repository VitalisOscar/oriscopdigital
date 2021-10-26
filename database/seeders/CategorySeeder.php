<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Fashion',
            'slug' => 'fashion',
            'order' => 1
        ]);

        Category::create([
            'name' => 'Real Estate',
            'slug' => 'real-estate',
            'order' => 1
        ]);

        Category::create([
            'name' => 'Others',
            'slug' => 'others',
            'order' => 0
        ]);

        Category::create([
            'name' => 'Retail',
            'slug' => 'retail',
            'order' => 1
        ]);

        Category::create([
            'name' => 'Automotive',
            'slug' => 'automotive',
            'order' => 1
        ]);

        Category::create([
            'name' => 'Electonics',
            'slug' => 'electronics',
            'order' => 1
        ]);
    }
}
