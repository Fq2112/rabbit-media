<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Pemesanan;
use App\Models\layanan;
use App\Models\Feedback;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');

        for ($c = 0; $c < 10; $c++) {
            $user = User::create([
                'name' => $faker->firstName . ' ' . $faker->lastName,
                'alamat' => $faker->address,
                'no_telp' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('secret'),
                'remember_token' => str_random(10),
                'status' => true,
            ]);

            Feedback::create([
                'user_id' => $user->id,
                'rate' => rand(1, 5),
                'comment' => $faker->sentence
            ]);

            Pemesanan::create([
                'user_id' => $user->id,
                'layanan_id' => rand(layanan::min('id'), layanan::max('id')),
                'deskripsi' => $faker->sentence
            ]);
        }

        User::find(1)->update([
            'name' => 'Fiqy Ainuzzaqy',
            'email' => 'fiqyainuzzaqy@mhs.unesa.ac.id'
        ]);
    }
}

