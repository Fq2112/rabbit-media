<?php

use App\Models\OrderRevision;
use App\Models\OrderLogs;
use App\Models\Schedule;
use App\Models\PaymentMethod;
use App\Models\layanan;
use App\Models\Studio;
use App\Admin;
use App\User;
use App\Models\Pemesanan;
use Faker\Factory;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id');

        foreach (layanan::take(30)->get() as $i => $layanan) {
            $i = $i + 1;
            $order = Pemesanan::create([
                'user_id' => rand(User::min('id'), User::max('id')),
                'layanan_id' => $layanan->id,
                'studio_id' => $layanan->isStudio == true ? rand(Studio::min('id'), Studio::max('id')) : null,
                'payment_id' => rand(PaymentMethod::min('id'), PaymentMethod::max('id')),
                'judul' => ucwords($faker->words(rand(1, 3), true)),
                'start' => '2019-06-' . str_pad($i, 2, 0, STR_PAD_LEFT) . ' ' .
                    now()->format('H:i:s'),
                'end' => '2019-06-' . str_pad($i, 2, 0, STR_PAD_LEFT) . ' ' .
                    now()->addHours(rand(1, 5))->format('H:i:s'),
                'deskripsi' => $faker->paragraph,
                'qty' => $layanan->isQty == true ? $layanan->qty : null,
                'hours' => $layanan->isHours == true ? $layanan->hours : null,
                'meeting_location' => $faker->address,
                'total_payment' => $layanan->harga,
                'payment_type' => 'FP',
                'payment_proof' => $faker->imageUrl(),
                'date_payment' => now()->format('Y-m-d'),
                'status_payment' => 2,
                'isAccept' => true,
            ]);

            Schedule::create([
                'pemesanan_id' => $order->id,
            ]);

            $log = OrderLogs::create([
                'pemesanan_id' => $order->id,
                'admin_id' => rand(Admin::min('id'), Admin::max('id')),
                'deskripsi' => $faker->paragraph,
                'files' => ["nature_big_" . rand(1, 2) . ".jpg", "nature_big_" . rand(1, 3) . ".jpg",
                    "nature_big_" . rand(1, 4) . ".jpg", "nature_big_" . rand(1, 5) . ".jpg"],
                'link' => $faker->imageUrl(),
                'isReady' => true,
                'isComplete' => true,
            ]);

            OrderRevision::create([
                'log_id' => $log->id,
                'deskripsi' => '<p align="justify">' . $faker->paragraph . '</p>',
            ]);

            OrderRevision::create([
                'log_id' => $log->id,
                'deskripsi' => '<p align="justify">' . $faker->paragraph . '</p>',
            ]);
        }

        $z = 1;
        for ($c = 1; $c <= 5; $c++) {
            Schedule::create([
                'judul' => 'Libur',
                'start' => '2019-07-' . str_pad($c, 2, 0, STR_PAD_LEFT) . ' ' .
                    now()->format('H:i:s'),
                'end' => '2019-07-' . str_pad($z++, 2, 0, STR_PAD_LEFT) . ' ' .
                    now()->addHours(rand(1, 5))->format('H:i:s'),
                'deskripsi' => $faker->paragraph,
                'isDayOff' => true
            ]);
        }

        $a = 1;
        $b = 1;
        for ($c = 1; $c <= 3; $c++) {
            $layanan = $layanan::inRandomOrder()->first();
            Pemesanan::create([
                'user_id' => User::first()->id,
                'layanan_id' => $layanan->id,
                'studio_id' => $layanan->isStudio == true ? rand(Studio::min('id'), Studio::max('id')) : null,
                'judul' => ucwords($faker->words(rand(1, 3), true)),
                'start' => '2019-08-' . $a++ . ' ' . now()->format('H:i:s'),
                'end' => '2019-08-' . $b++ . ' ' . now()->addHours(rand(1, 5))->format('H:i:s'),
                'deskripsi' => $faker->paragraph,
                'qty' => $layanan->isQty == true ? $layanan->qty : null,
                'hours' => $layanan->isHours == true ? $layanan->hours : null,
                'meeting_location' => $faker->address,
                'total_payment' => $layanan->harga,
                'status_payment' => 0,
            ]);
        }
    }
}
