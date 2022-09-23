<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        //$this->call(AdminSeeder::class);
        //$this->call(CategorySeeder::class);
        //$this->call(ColorSeeder::class);
        //$this->call(MaterialSeeder::class);
        //$this->call(OccasionSeeder::class);
        //$this->call(PatternSeeder::class);
        //$this->call(SleeveSeeder::class);
        $this->call(ProductSeeder::class);
        //$this->call(ProductsAttributesSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
