<?php

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
        $jenis = ['background polos', 'background tematik', 'private'];
        $key = array_rand($jenis, 3);

        for ($c = 0; $c < 10; $c++) {
            Studio::create([
                'nama' => $faker->firstName . ' Studio',
                'jenis' => $jenis[$key[rand(0, 2)]],
                'harga' => rand(200000, 500000)
            ]);
        }
    }
}
