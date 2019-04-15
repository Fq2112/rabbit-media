<?php

use App\Models\JenisStudio;
use App\Models\Studio;
use Faker\Factory;
use Illuminate\Database\Seeder;

class StudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id');

        JenisStudio::create([
            'nama' => 'Background Polos'
        ]);

        JenisStudio::create([
            'nama' => 'Background Tematik'
        ]);

        JenisStudio::create([
            'nama' => 'Private'
        ]);

        for ($c = 0; $c < 5; $c++) {
            Studio::create([
                'jenis_id' => 1,
                'nama' => $faker->firstName . ' Studio',
                'harga' => rand(200000, 500000)
            ]);

            Studio::create([
                'jenis_id' => 2,
                'nama' => $faker->firstName . ' Studio',
                'harga' => rand(200000, 500000)
            ]);

            Studio::create([
                'jenis_id' => 3,
                'nama' => $faker->firstName . ' Studio',
                'harga' => rand(200000, 500000)
            ]);
        }
    }
}
