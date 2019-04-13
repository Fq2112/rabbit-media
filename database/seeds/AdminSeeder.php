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

            } elseif ($role == Role::CEO) {
                Admin::create([
                    'name' => 'Fiqy Ainuzzaqy',
                    'email' => 'fiqy_a@icloud.com',
                    'password' => bcrypt('Fiqy2112'),
                    'remember_token' => str_random(10),
                    'role' => $role,
                    'deskripsi' => 'Fiqy telah berkiprah di dunia animasi dan editing video sejak 2009 dan berperan sebagai front-end dan back-end developer sejak 2015.',
                    'facebook' => 'FqNkk',
                    'twitter' => 'FqNkk',
                    'instagram' => 'fq_whysoserious',
                    'whatsapp' => '+628563094333'
                ]);

            } elseif ($role == Role::CTO) {
                Admin::create([
                    'name' => 'Diaz Ardian',
                    'email' => 'ddaiazardian@gmail.com',
                    'password' => bcrypt('secret'),
                    'remember_token' => str_random(10),
                    'role' => $role,
                    'deskripsi' => 'Diaz saat ini berperan sebagai sound engineer dan videografer dalam proses produksi video. Dia mulai menekuni bidang ini pada tahun 2012.',
                    'facebook' => 'dizaralvino',
                    'twitter' => 'diaz_Apocalyps',
                    'instagram' => 'diazardian',
                    'whatsapp' => '+6281236678891'
                ]);

            } elseif ($role == Role::ADMIN) {
                Admin::create([
                    'name' => 'Laras Sulistyorini',
                    'email' => 'larassoemardjo@gmail.com',
                    'password' => bcrypt('secret'),
                    'remember_token' => str_random(10),
                    'role' => $role,
                    'deskripsi' => 'Laras saat ini berperan sebagai fotografer indoor. Dia mulai menekuni bidang ini pada tahun 2016.',
                    'facebook' => 'lsrini1',
                    'twitter' => 'larassoemardjo',
                    'instagram' => 'lar.assu',
                    'whatsapp' => '+6282234389870'
                ]);

            } elseif ($role == Role::COO) {
                Admin::create([
                    'name' => 'Moch. Alfin Nasrul Huda',
                    'email' => 'alfinnasrul11@gmail.com',
                    'password' => bcrypt('secret'),
                    'remember_token' => str_random(10),
                    'role' => $role,
                    'deskripsi' => 'Alfin saat ini berperan sebagai fotografer baik indoor maupun outdoor. Dia mulai menekuni bidang ini pada tahun 2011.',
                    'facebook' => 'alfinnasrul',
                    'twitter' => 'alfinnasrul',
                    'instagram' => 'alfinnasrul',
                    'whatsapp' => '+6285608512411'
                ]);

            } elseif ($role == Role::DESIGNER) {
                Admin::create([
                    'name' => 'Satria Bagus Wicaksana',
                    'email' => $faker->unique()->safeEmail,
                    'password' => bcrypt('secret'),
                    'remember_token' => str_random(10),
                    'role' => $role,
                    'deskripsi' => 'Satria saat ini berperan sebagai fotografer dan desainer.',
                    'facebook' => 'saatria',
                    'twitter' => 'saatria',
                    'instagram' => 'saatria',
                    'whatsapp' => '+6282233726816'
                ]);

                Admin::create([
                    'name' => 'M. Thoriqul Falahi',
                    'email' => $faker->unique()->safeEmail,
                    'password' => bcrypt('secret'),
                    'remember_token' => str_random(10),
                    'role' => $role,
                    'deskripsi' => 'Ahi saat ini berperan sebagai fotografer dan desainer.',
                    'facebook' => 'thorotoar',
                    'twitter' => 'thorotoar',
                    'instagram' => 'thorotoar',
                    'whatsapp' => '+6285733980308'
                ]);

            } elseif ($role == Role::VIDEOGRAPHER) {
                Admin::create([
                    'name' => 'Septian Dwi Prasetya',
                    'email' => 'dwiseptian470@gmail.com',
                    'password' => bcrypt('secret'),
                    'remember_token' => str_random(10),
                    'role' => $role,
                    'deskripsi' => $faker->sentence,
                    'facebook' => 'septian.dwip.58760',
                    'twitter' => 'septiiandwiprasetya',
                    'instagram' => 'septiiandwiprasetya',
                    'whatsapp' => '+6282233324341'
                ]);

                Admin::create([
                    'name' => 'Moch. Syarief Hidayat',
                    'email' => 'mochsyariefhidayat@gmail.com',
                    'password' => bcrypt('secret'),
                    'remember_token' => str_random(10),
                    'role' => $role,
                    'deskripsi' => 'Syarif saat ini berperan sebagai videografer dan telah berpengalaman dalam pembuatan wedding clip sejak tahun 2012.',
                    'facebook' => 'syarif.lha',
                    'twitter' => 'syarif.lha',
                    'instagram' => 'msyariefhdyt',
                    'whatsapp' => '+6281327373807'
                ]);

            } elseif ($role == Role::PHOTOGRAPHER) {
                Admin::create([
                    'name' => 'Irza Haryo Prabowo',
                    'email' => 'irzaharyoo@gmail.com',
                    'password' => bcrypt('secret'),
                    'remember_token' => str_random(10),
                    'role' => $role,
                    'deskripsi' => 'Irza saat ini berperan sebagai fotografer yang specialist dalam fotografi outdoor. Dia mulai menekuni bidang ini pada tahun 2012.',
                    'facebook' => 'ir.za.98',
                    'twitter' => 'IrzaProvox',
                    'instagram' => 'irzaharyo',
                    'whatsapp' => '+62816854481'
                ]);
            }
        }
    }
}
