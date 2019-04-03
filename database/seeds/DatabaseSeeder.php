<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PortofolioSeeder::class,
            LayananSeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
            AboutSeeder::class,
        ]);
    }
}
