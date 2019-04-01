<?php

use App\Models\Galeri;
use App\Models\JenisPortofolio;
use App\Models\Portofolio;
use Illuminate\Database\Seeder;
use Faker\Factory;

class PortofolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');

        JenisPortofolio::create([
            'icon' => 'fa-snowman',
            'nama' => 'Animations',
        ]);

        JenisPortofolio::create([
            'icon' => 'fa-palette',
            'nama' => 'Designs',
        ]);

        JenisPortofolio::create([
            'icon' => 'fa-images',
            'nama' => 'Photos',
        ]);

        JenisPortofolio::create([
            'icon' => 'fa-film',
            'nama' => 'Videos',
        ]);

        $x1 = 1;
        for ($c = 0; $c < 5; $c++) {
            Portofolio::create([
                'jenis_id' => 1,
                'nama' => 'Portfolio ' . $x1++,
                'deskripsi' => $faker->sentence,
                'cover' => 'img_' . rand(1, 7) . '.jpg',
            ]);
        }

        $x2 = 6;
        for ($c = 0; $c < 10; $c++) {
            Portofolio::create([
                'jenis_id' => 2,
                'nama' => 'Portfolio ' . $x2++,
                'deskripsi' => $faker->sentence,
                'cover' => 'img_' . rand(1, 7) . '.jpg',
            ]);
        }

        $x3 = 16;
        for ($c = 0; $c < 15; $c++) {
            Portofolio::create([
                'jenis_id' => 3,
                'nama' => 'Portfolio ' . $x3++,
                'deskripsi' => $faker->sentence,
                'cover' => 'img_' . rand(1, 7) . '.jpg',
            ]);
        }

        $x4 = 31;
        for ($c = 0; $c < 20; $c++) {
            Portofolio::create([
                'jenis_id' => 4,
                'nama' => 'Portfolio ' . $x4++,
                'deskripsi' => $faker->sentence,
                'cover' => 'img_' . rand(1, 7) . '.jpg',
            ]);
        }

        $x = 1;
        for ($c = 0; $c < 250; $c++) {
            Galeri::create([
                'portofolio_id' => rand(Portofolio::min('id'), Portofolio::max('id')),
                'nama' => 'Gallery ' . $x++,
                'deskripsi' => $faker->sentence,
                'photo' => 'nature_big_' . rand(1, 9) . '.jpg',
            ]);
        }

        $y = 1;
        for ($c = 0; $c < 250; $c++) {
            Galeri::create([
                'portofolio_id' => rand(Portofolio::min('id'), Portofolio::max('id')),
                'nama' => 'Gallery ' . $y++,
                'deskripsi' => $faker->sentence,
                'video' => 'https://youtu.be/3-RsRaScPjE',
                'thumbnail' => 'nature_big_' . rand(1, 9) . '.jpg',
            ]);
        }
    }
}
