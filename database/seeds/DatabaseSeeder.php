<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CampusTableSeeder::class);

        $this->call(CategoriesTableSeeder::class);

        $this->call(ShopTypeTableSeeder::class);
 
        $this->call(AdminTableSeeder::class);
    }
}
