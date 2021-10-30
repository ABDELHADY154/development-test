<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productOne = Product::find(rand(1, Product::all()->count()));
        $orderOne = Order::create([

            'user_id' => rand(1, User::all()->count()),
            'payment_id' => rand(1, Payment::all()->count()),
            'price' => $productOne->price,
        ]);
        DB::table('order_product')->insert([
            'order_id' => $orderOne->id,
            'product_id' => $productOne->id
        ]);

        $productTwo = Product::find(rand(1, Product::all()->count()));
        $orderTwo = Order::create([

            'user_id' => rand(1, User::all()->count()),
            'payment_id' => rand(1, Payment::all()->count()),
            'price' => $productTwo->price,
        ]);
        DB::table('order_product')->insert([
            'order_id' => $orderTwo->id,
            'product_id' => $productTwo->id
        ]);
    }
}
