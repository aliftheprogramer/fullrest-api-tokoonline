<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat data dummy untuk users
        User::factory()->count(10)->create();

        // Buat data dummy untuk products
        Product::factory()->count(10)->create();

        // Buat data dummy untuk orders dan order_items
        Order::factory()->count(10)->create()->each(function ($order) {
            // Pilih secara acak antara 1 sampai 3 produk untuk setiap order
            $products = Product::all()->random(rand(1, 3));
            $products->each(function ($product) use ($order) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 5),
                    'price' => $product->price,
                ]);
            });
        });
    }
}
