<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'name' => $faker->name,
                'description' => $faker->sentence(10),
                'price' => $faker->randomFloat(2, 10, 100),
                'stock' => $faker->numberBetween(1, 100),
                'image' => null, // Atau sesuaikan dengan path gambar jika ada
            ]);
        }
    }
}
