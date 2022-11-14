<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Payment;
use App\Models\Product;
use App\Models\SalesType;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Faker\Factory as Faker;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transaction::truncate();
        TransactionDetail::truncate();

        $user = User::pluck('id');
        $payment = Payment::pluck('id');
        $sales_type = SalesType::pluck('id');
        $faker = Faker::create();

        // for ($i=0; $i < ; $i++) { 
        // }

        for ($i=0; $i < 20; $i++) { 
            $date = now()->subDays(1)->addMinutes($i+1);
            $transaction_id = Transaction::insertGetId([
                'sales_type_id' => $faker->randomElement($sales_type),
                'user_id' => $faker->randomElement($user),
                'customer_id' => 0,
                'name' => $faker->name(),
                'discount' => 0,
                'tax' => 0,
                // 'tax' => rand(0,1) ? rand(10,20)*20 : rand(10,20).'%',
                'total' => 0,
                'payment_id' => $faker->randomElement($payment),
                'status' => rand(0, 1),
                'created_at' => $date,
                'updated_at' => $date 
            ]);

            $sub_total = [];
            foreach (Product::inRandomOrder()->limit(rand(3, 7))->get() as $key => $value) {
                $random_qty = rand(1, 5);
                $transaction_detail = TransactionDetail::insert([
                    'transaction_id' => $transaction_id,
                    'product_id' => $value->id,
                    'quantity' => $random_qty,
                    'created_at' => $date, 
                    'updated_at' => $date
                ]);
                $sub_total[$key] = $value->price * $random_qty;
            }
            Transaction::find($transaction_id)->update(['total' => array_sum($sub_total)]);
        }
    }
}
