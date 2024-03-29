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
        $types = ['Food', 'Hot Coffee', 'Cold Coffee', 'Cake', 'Desserts', 'Soup & Salad', 'Drink', 'Snack'];
        foreach ($types as $key => $value) {
            Category::insert([
                'name' => $value,
                'created_at' => now(), 
                'updated_at' => now()
            ]);
        }
    }
}
