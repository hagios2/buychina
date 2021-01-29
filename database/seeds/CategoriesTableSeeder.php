<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['category' => 'Electronics']);

        Category::create(['category' => 'Phones']);

        Category::create(['category' => 'Fashion']);

        Category::create(['category' => 'Home and Living']);

        Category::create(['category' => 'Beauty and Perfumes']);

        Category::create(['category' => 'Food and Snacks']);

        Category::create(['category' => 'Games and Console']);

        Category::create(['category' => 'Skills and Services']);

        Category::create(['category' => 'Entertainment']);

        Category::create(['category' => 'Other']);
    }
}
