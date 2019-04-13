<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Pemesanan;
use App\Models\layanan;
use App\Models\Contact;
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

        for ($c = 0; $c < 80; $c++) {
            User::create([
                'name' => $faker->firstName . ' ' . $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('secret'),
                'remember_token' => str_random(10),
                'status' => true,
                'jk' => rand(0, 1) ? 'male' : 'female',
                'tgl_lahir' => $faker->date('Y-m-d', '2000-12-30'),
                'no_telp' => $faker->phoneNumber,
                'alamat' => $faker->address,
                'lat' => $faker->latitude,
                'long' => $faker->longitude,
            ]);
        }

        User::find(1)->update([
            'name' => 'Fiqy Ainuzzaqy',
            'jk' => 'male',
            'tgl_lahir' => '1997-10-15',
            'no_telp' => '08563094333',
            'email' => 'fiqyainuzzaqy@mhs.unesa.ac.id'
        ]);

        foreach (User::whereBetween('id', [1, 5])->get() as $user) {
            Feedback::create([
                'user_id' => $user->id,
                'rate' => round($faker->randomFloat(8, 0.5, 1) * 2) / 2,
                'comment' => $faker->sentence
            ]);
        }

        foreach (User::whereBetween('id', [6, 15])->get() as $user) {
            Feedback::create([
                'user_id' => $user->id,
                'rate' => round($faker->randomFloat(8, 1.5, 2) * 2) / 2,
                'comment' => $faker->sentence
            ]);
        }

        foreach (User::whereBetween('id', [16, 30])->get() as $user) {
            Feedback::create([
                'user_id' => $user->id,
                'rate' => round($faker->randomFloat(8, 2.5, 3) * 2) / 2,
                'comment' => $faker->sentence
            ]);
        }

        foreach (User::whereBetween('id', [31, 50])->get() as $user) {
            Feedback::create([
                'user_id' => $user->id,
                'rate' => round($faker->randomFloat(8, 3.5, 4) * 2) / 2,
                'comment' => $faker->sentence
            ]);
        }

        foreach (User::whereBetween('id', [51, 80])->get() as $user) {
            Feedback::create([
                'user_id' => $user->id,
                'rate' => round($faker->randomFloat(8, 4.5, 5) * 2) / 2,
                'comment' => $faker->sentence
            ]);
        }

        foreach (User::take(10)->get()->shuffle()->all() as $user) {
            Contact::create([
                'name' => $user->name,
                'email' => $user->email,
                'subject' => ucfirst($faker->sentence),
                'message' => ucfirst($faker->paragraph)
            ]);
        }
    }
}

