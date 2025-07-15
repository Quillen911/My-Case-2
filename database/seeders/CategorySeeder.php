<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['id' => 1, 'category_title' => 'Roman'],
            ['id' => 2, 'category_title' => 'Şiir'],
            ['id' => 3, 'category_title' => 'Tarih'],
            ['id' => 4, 'category_title' => 'Felsefe'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
