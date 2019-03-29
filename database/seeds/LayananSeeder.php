<?php

use App\Models\JenisLayanan;
use App\Models\layanan;
use Faker\Factory;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');

        JenisLayanan::create([
            'nama' => 'Digital Offset',
            'deskripsi' => $faker->sentence
        ]);

        JenisLayanan::create([
            'nama' => 'Graphic Design',
            'deskripsi' => $faker->sentence
        ]);

        JenisLayanan::create([
            'nama' => 'Mockup Design',
            'deskripsi' => $faker->sentence
        ]);

        JenisLayanan::create([
            'nama' => 'Photography',
            'deskripsi' => $faker->sentence
        ]);

        JenisLayanan::create([
            'nama' => 'Videography',
            'deskripsi' => $faker->sentence
        ]);

        JenisLayanan::create([
            'nama' => 'Wedding',
            'deskripsi' => $faker->sentence
        ]);

        foreach(JenisLayanan::all() as $row){
            layanan::create([
                'jenis_id' => $row->id,
                'paket' => $faker->word.' Package',
                'harga' => $faker->numberBetween($min = 1000000, $max = 1500000),
                'diskon' => $faker->numberBetween($min = 0, $max = 100),
                'keuntungan' => '<ul><li>Lorem</li><li>Ipsum</li><li>Dolor</li><li>Sit amet</li></ul>',
                'isBest' => true
            ]);
        }
    }
}
