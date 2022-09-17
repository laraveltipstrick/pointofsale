<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SalesType;

class SalesTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SalesType::truncate();

        $types = ['Dine In', 'Take Away', 'Delivery Service'];
        foreach ($types as $key => $value) {
            SalesType::insert([
                'name' => $value,
                'created_at' => now(), 
                'updated_at' => now()
            ]);
        }
    }
}
