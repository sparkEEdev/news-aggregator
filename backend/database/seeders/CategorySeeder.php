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
            ['slug' => 'business', 'name' => 'Business'],
            ['slug' => 'entertainment', 'name' => 'Entertainment'],
            ['slug' => 'general', 'name' => 'General'],
            ['slug' => 'health', 'name' => 'Health'],
            ['slug' => 'science', 'name' => 'Science'],
            ['slug' => 'sports', 'name' => 'Sports'],
            ['slug' => 'technology', 'name' => 'Technology'],
        ];

        foreach ($categories as $category) {
            Category::upsert(
                $category,
                [
                    'slug'
                ],
            );
        }
    }
}
