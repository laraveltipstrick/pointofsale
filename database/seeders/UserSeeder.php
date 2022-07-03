<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::insert([
            [
                'name' => 'Johny Depp',
                'email' => 'admin@example.com',
                'password' => bcrypt(111111),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'John Doe',
                'email' => 'staff@example.com',
                'password' => bcrypt(111111),
                'role' => 'staff',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
