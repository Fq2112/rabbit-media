<?php

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

        $i1 = 1;
        for ($c = 0; $c < 2; $c++) {
            Portofolio::create([
                'jenis_id' => 1,
                'nama' => $faker->words(rand(1, 3), true),
                'deskripsi' => $faker->sentence,
                'cover' => 'img_' . $i1++ . '.jpg',
                'photos' => ['photo1.jpg', 'photo2.jpg', 'photo3.jpg', 'photo4.jpg', 'photo5.jpg'],
                'videos' => ['video1.mp4', 'video2.mp4', 'video3.mp4', 'video4.mp4', 'video5.mp4']
            ]);
        }

        $i2 = 3;
        for ($c = 0; $c < 2; $c++) {
            Portofolio::create([
                'jenis_id' => 2,
                'nama' => $faker->words(rand(1, 3), true),
                'deskripsi' => $faker->sentence,
                'cover' => 'img_' . $i2++ . '.jpg',
                'photos' => ['photo1.jpg', 'photo2.jpg', 'photo3.jpg', 'photo4.jpg', 'photo5.jpg'],
            ]);
        }

        $i3 = 5;
        for ($c = 0; $c < 2; $c++) {
            Portofolio::create([
                'jenis_id' => 3,
                'nama' => $faker->words(rand(1, 3), true),
                'deskripsi' => $faker->sentence,
                'cover' => 'img_' . $i3++ . '.jpg',
                'photos' => ['photo1.jpg', 'photo2.jpg', 'photo3.jpg', 'photo4.jpg', 'photo5.jpg'],
            ]);
        }

        for ($c = 0; $c < 1; $c++) {
            Portofolio::create([
                'jenis_id' => 4,
                'nama' => $faker->words(rand(1, 3), true),
                'deskripsi' => $faker->sentence,
                'cover' => 'img_7.jpg',
                'videos' => ['video1.mp4', 'video2.mp4', 'video3.mp4', 'video4.mp4', 'video5.mp4']
            ]);
        }
    }
}
