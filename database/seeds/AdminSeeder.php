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
            } elseif ($role == Role::STAFF_DESAIN) {
                for ($c = 0; $c < (($role == Role::STAFF_DESAIN) ? 3 : 1); $c++) {
                    Admin::create([
                        'name' => $faker->firstName . ' ' . $faker->lastName,
                        'email' => $faker->unique()->safeEmail,
                        'password' => bcrypt('secret'),
                        'remember_token' => str_random(10),
                        'role' => $role,
                    ]);
                }
            } elseif ($role == Role::STAFF_VIDEO) {
                for ($c = 0; $c < (($role == Role::STAFF_VIDEO) ? 3 : 1); $c++) {
                    Admin::create([
                        'name' => $faker->firstName . ' ' . $faker->lastName,
                        'email' => $faker->unique()->safeEmail,
                        'password' => bcrypt('secret'),
                        'remember_token' => str_random(10),
                        'role' => $role,
                    ]);
                }
            } elseif ($role == Role::STAFF_FOTO) {
                for ($c = 0; $c < (($role == Role::STAFF_FOTO) ? 3 : 1); $c++) {
                    Admin::create([
                        'name' => $faker->firstName . ' ' . $faker->lastName,
                        'email' => $faker->unique()->safeEmail,
                        'password' => bcrypt('secret'),
                        'remember_token' => str_random(10),
                        'role' => $role,
                    ]);
                }
            }
        }
    }
}
