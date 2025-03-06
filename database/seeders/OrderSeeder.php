<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use Faker\Generator as Faker;
use DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for ($i = 0; $i < 100; $i++) {
            $order = new Order();
            $order->customer_id =  $faker->numberBetween(0, 100);
            $order->date_placed = $faker->dateTimeBetween('-2 month', '+9 month'); 
            $order->shipping = $faker->dateTimeBetween('-2 month', '+9 month'); 
            $order->status = 'pending';
            $order->shipping = 10;
            $order->save();

            for ($i = 0; $i < 4; $i++) {
        		DB::table('orderline')->insert(
                    ['item_id' => $faker->numberBetween(1, 36), 
                     'orderinfo_id' => $order->orderinfo_id,
                     'quantity' => $faker->numberBetween(1, 5)
                    ]
                    );
            }
        }
    }
}
