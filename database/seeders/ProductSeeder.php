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

        $food = ['Fried Rice', 'Spring Rolls', 'Egg Roll', 'Mozzarella Stick', 'Chicken Garlic', 'Chicken Nugget'];
        $hotCoffee = ['Americano', 'Espresso', 'Cappucino', 'Latte Machiato', 'Vanilla Latte', 'Hazelnut Latte', 'Hot Red Velvet'];
        $coldCoffee = ['Ice Cafe Latte', 'Ice Watermelon Latte', 'Ice Americano', 'Ice Coconut Espresso', 'Ice Mochaccino'];
        $cake = ['Banana Pudding', 'Sweet Vanila', 'Cheesecake', 'Donuts Chocolate', 'Chocolate Brownies'];
        $dessert = ['Classic Vanilla Gelato', 'Limoncello Gelato', 'Strawberry Cheese Cake', 'Chocolate Lava Cake', 'Red Velvet', 'Fruit Compole'];
        $soupSalad = ['Red Pepper Soup', 'Mushroom & Chicken Soup', 'Clam Chowder', 'Crab Soup'];
        $drink = ['Chocolate', 'Matcha', 'Hazelnut', 'Caramel', 'Guava Juice', 'Strawberry', 'Lemon Tea'];

        foreach ($food as $key => $value) {
            Product::insert([
                'category_id' => $category[0],
                'name' => $value,
                'barcode' => $faker->ean13(),
                'price' => 10 * $faker->randomDigitNotNull(),
                'cost' => 3 * $faker->randomDigitNotNull(),
                'quantity' => $faker->randomNumber(2, true),
                'description' => $faker->sentence(),
                'status' => rand(0, 1),
            ]);
        }

        foreach ($hotCoffee as $key => $value) {
            Product::insert([
                'category_id' => $category[1],
                'name' => $value,
                'barcode' => $faker->ean13(),
                'price' => 10 * $faker->randomDigitNotNull(),
                'cost' => 3 * $faker->randomDigitNotNull(),
                'quantity' => $faker->randomNumber(2, true),
                'description' => $faker->sentence(),
                'status' => rand(0, 1),
            ]);
        }

        foreach ($coldCoffee as $key => $value) {
            Product::insert([
                'category_id' => $category[2],
                'name' => $value,
                'barcode' => $faker->ean13(),
                'price' => 10 * $faker->randomDigitNotNull(),
                'cost' => 3 * $faker->randomDigitNotNull(),
                'quantity' => $faker->randomNumber(2, true),
                'description' => $faker->sentence(),
                'status' => rand(0, 1),
            ]);
        }

        foreach ($cake as $key => $value) {
            Product::insert([
                'category_id' => $category[3],
                'name' => $value,
                'barcode' => $faker->ean13(),
                'price' => 10 * $faker->randomDigitNotNull(),
                'cost' => 3 * $faker->randomDigitNotNull(),
                'quantity' => $faker->randomNumber(2, true),
                'description' => $faker->sentence(),
                'status' => rand(0, 1),
            ]);
        }

        foreach ($dessert as $key => $value) {
            Product::insert([
                'category_id' => $category[4],
                'name' => $value,
                'barcode' => $faker->ean13(),
                'price' => 10 * $faker->randomDigitNotNull(),
                'cost' => 3 * $faker->randomDigitNotNull(),
                'quantity' => $faker->randomNumber(2, true),
                'description' => $faker->sentence(),
                'status' => rand(0, 1),
            ]);
        }

        foreach ($soupSalad as $key => $value) {
            Product::insert([
                'category_id' => $category[5],
                'name' => $value,
                'barcode' => $faker->ean13(),
                'price' => 10 * $faker->randomDigitNotNull(),
                'cost' => 3 * $faker->randomDigitNotNull(),
                'quantity' => $faker->randomNumber(2, true),
                'description' => $faker->sentence(),
                'status' => rand(0, 1),
            ]);
        }

        foreach ($drink as $key => $value) {
            Product::insert([
                'category_id' => $category[6],
                'name' => $value,
                'barcode' => $faker->ean13(),
                'price' => 10 * $faker->randomDigitNotNull(),
                'cost' => 3 * $faker->randomDigitNotNull(),
                'quantity' => $faker->randomNumber(2, true),
                'description' => $faker->sentence(),
                'status' => rand(0, 1),
            ]);
        }
        // for ($i=0; $i < 20; $i++) { 
        //     $variant = rand(0, 1);
        //     Product::insert([
        //         'category_id' => $faker->randomElement($category),
        //         'name' => $faker->firstName(),
        //         'barcode' => $faker->ean13(),
        //         // 'sku' => $faker->randomNumber(5, true),
        //         'price' => 10 * $faker->randomDigitNotNull(),
        //         'cost' => 3 * $faker->randomDigitNotNull(),
        //         'quantity' => $faker->randomNumber(2, true),
        //         'description' => $faker->sentence(),
        //         'status' => rand(0, 1),
        //     ]);
        // }

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
