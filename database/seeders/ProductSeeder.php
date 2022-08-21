<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();
        $category = Category::pluck('id');
        $faker = Faker::create();
        
        for ($i=0; $i < 20; $i++) { 
            $variant = rand(0, 1);
            Product::insert([
                'category_id' => $faker->randomElement($category),
                'name' => $faker->firstName(),
                'barcode' => $faker->ean13(),
                // 'sku' => $faker->randomNumber(5, true),
                'price' => 10 * $faker->randomDigitNotNull(),
                'cost' => 3 * $faker->randomDigitNotNull(),
                'quantity' => $faker->randomNumber(2, true),
                'description' => $faker->sentence(),
                'status' => rand(0, 1),
            ]);
        }

        // $pro = Product::where('has_variant', 1)->get();

        // foreach ($pro as $key => $item) {
        //     for ($i=0; $i < rand(2, 5); $i++) { 
        //         Variant::insert([
        //             'product_id' => $item->id,
        //             'name' => $faker->firstName(),
        //             'price' => (50 * $faker->randomDigitNotNull()),
        //             'quantity' => $faker->randomDigitNotNull(),
        //             'cost' => (10 * $faker->randomDigitNotNull())
        //         ]);
        //     }
        // }


    }
}
