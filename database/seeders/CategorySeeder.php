<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();
        Category::insert([
            ['name' => 'Food', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Drink', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dessert', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
