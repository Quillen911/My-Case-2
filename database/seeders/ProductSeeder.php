<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;


class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                "title" => "İnce Memed",
                "category_id" => 1,
                "author" => "Yaşar Kemal",
                "list_price" => 48.75,
                "stock_quantity" => 10
            ],
            [
                "title" => "Tutunamayanlar",
                "category_id" => 1,
                "author" => "Oğuz Atay",
                "list_price" => 90.3,
                "stock_quantity" => 20
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
