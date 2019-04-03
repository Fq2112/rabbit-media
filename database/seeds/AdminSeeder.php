<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Support\Role;
use App\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');

        foreach (Role::ALL as $role) {
            if ($role == Role::ROOT) {
                Admin::create([
                    'name' => 'Rabbit Media',
                    'email' => 'rm.rabbitmedia@gmail.com',
                    'password' => bcrypt('secret'),
                    'remember_token' => str_random(10),
                    'role' => $role,
                ]);
            } elseif ($role == Role::DESIGNER) {
                for ($c = 0; $c < (($role == Role::DESIGNER) ? 3 : 1); $c++) {
                    Admin::create([
                        'name' => $faker->firstName . ' ' . $faker->lastName,
                        'email' => $faker->unique()->safeEmail,
                        'password' => bcrypt('secret'),
                        'remember_token' => str_random(10),
                        'role' => $role,
                        'deskripsi' => $faker->sentence,
                        'facebook' => strtolower($faker->firstName . '.' . $faker->lastName),
                        'twitter' => strtolower($faker->firstName . '.' . $faker->lastName),
                        'instagram' => strtolower($faker->firstName . '.' . $faker->lastName),
                        'whatsapp' => '+628563094' . rand(100, 999)
                    ]);
                }
            } elseif ($role == Role::VIDEOGRAPHER) {
                for ($c = 0; $c < (($role == Role::VIDEOGRAPHER) ? 3 : 1); $c++) {
                    Admin::create([
                        'name' => $faker->firstName . ' ' . $faker->lastName,
                        'email' => $faker->unique()->safeEmail,
                        'password' => bcrypt('secret'),
                        'remember_token' => str_random(10),
                        'role' => $role,
                        'deskripsi' => $faker->sentence,
                        'facebook' => strtolower($faker->firstName . '.' . $faker->lastName),
                        'twitter' => strtolower($faker->firstName . '.' . $faker->lastName),
                        'instagram' => strtolower($faker->firstName . '.' . $faker->lastName),
                        'whatsapp' => '+628563094' . rand(100, 999)
                    ]);
                }
            } elseif ($role == Role::PHOTOGRAPHER) {
                for ($c = 0; $c < (($role == Role::PHOTOGRAPHER) ? 3 : 1); $c++) {
                    Admin::create([
                        'name' => $faker->firstName . ' ' . $faker->lastName,
                        'email' => $faker->unique()->safeEmail,
                        'password' => bcrypt('secret'),
                        'remember_token' => str_random(10),
                        'role' => $role,
                        'deskripsi' => $faker->sentence,
                        'facebook' => strtolower($faker->firstName . '.' . $faker->lastName),
                        'twitter' => strtolower($faker->firstName . '.' . $faker->lastName),
                        'instagram' => strtolower($faker->firstName . '.' . $faker->lastName),
                        'whatsapp' => '+628563094' . rand(100, 999)
                    ]);
                }
            }
        }
    }
}
