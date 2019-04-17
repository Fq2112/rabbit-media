<?php

use App\Models\Schedule;
use App\Models\PaymentMethod;
use App\Models\layanan;
use App\Models\Studio;
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

        $x = 1;
        for ($c = 1; $c <= 30; $c++) {
            $layanan = layanan::where('id', rand(1, 35))->first();
            $code = rand(100, 999);

            $order = Pemesanan::create([
                'user_id' => rand(User::min('id'), User::max('id')),
                'layanan_id' => $layanan->id,
                'studio_id' => $layanan->isStudio == true ? rand(Studio::min('id'), Studio::max('id')) : null,
                'payment_id' => rand(PaymentMethod::min('id'), PaymentMethod::max('id')),
                'judul' => ucwords($faker->words(rand(1, 3), true)),
                'start' => '2019-04-' . str_pad($c, 2, 0, STR_PAD_LEFT) . ' ' . now()->format('H:i:s'),
                'end' => rand(0, 1) ? null : '2019-04-' . str_pad($x++, 2, 0, STR_PAD_LEFT) . ' ' . now()->addHours(rand(1, 5))->format('H:i:s'),
                'deskripsi' => $faker->paragraph,
                'qty' => $layanan->isQty == true ? $layanan->qty : null,
                'hours' => $layanan->isHours == true ? $layanan->qty : null,
                'payment_code' => $code,
                'total_payment' => $layanan->harga - $code,
                'payment_proof' => $faker->imageUrl(),
                'date_payment' => now()->format('Y-m-d'),
                'isPaid' => true,
                'isAccept' => true,
            ]);

            Schedule::create([
                'pemesanan_id' => $order->id,
            ]);
        }

        $y = 1;
        for ($c = 1; $c <= 5; $c++) {
            Schedule::create([
                'judul' => 'Libur',
                'start' => '2019-05-' . str_pad($c, 2, 0, STR_PAD_LEFT) . ' ' . now()->format('H:i:s'),
                'end' => '2019-05-' . str_pad($y++, 2, 0, STR_PAD_LEFT) . ' ' . now()->addHours(rand(1, 5))->format('H:i:s'),
                'deskripsi' => $faker->paragraph,
                'isDayOff' => true
            ]);
        }
    }
}
