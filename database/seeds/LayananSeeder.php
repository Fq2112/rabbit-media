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
            'icon' => 'fa fa-print',
            'icon_code' => '\f02f',
            'nama' => 'Digital Offset',
            'deskripsi' => $faker->sentence
        ]);

        JenisLayanan::create([
            'icon' => 'fa fa-laptop',
            'icon_code' => '\f109',
            'nama' => 'Graphic Design',
            'deskripsi' => $faker->sentence
        ]);

        JenisLayanan::create([
            'icon' => 'fab fa-codepen',
            'icon_code' => '\f1cb',
            'nama' => 'Mockup Design',
            'deskripsi' => $faker->sentence
        ]);

        JenisLayanan::create([
            'icon' => 'fa fa-camera',
            'icon_code' => '\f030',
            'nama' => 'Photography',
            'deskripsi' => $faker->sentence
        ]);

        JenisLayanan::create([
            'icon' => 'fa fa-video',
            'icon_code' => '\f03d',
            'nama' => 'Videography',
            'deskripsi' => $faker->sentence
        ]);

        JenisLayanan::create([
            'icon' => 'fa fa-venus-mars',
            'icon_code' => '\f228',
            'nama' => 'Wedding',
            'deskripsi' => $faker->sentence
        ]);

        layanan::create([
            'jenis_id' => 6,
            'paket' => 'Pre-wedding Photo',
            'harga' => '1500000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>5 foto terbaik dengan edit</li><li>2 kostum/baju</li><li>Cetak foto 10R 2pcs</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 6,
            'paket' => 'Pre-wedding Clip',
            'harga' => '2000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>Cinematic 2 camera (durasi max. 5 menit)</li><li>Max. 2x revisi</li><li>Free edit photo clip (durasi max. 1 menit)</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 6,
            'paket' => 'Emerald Photo Pack',
            'harga' => '2000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>1 album standard</li><li>Cetak foto 4R 120pcs</li><li>Cetak foto 10R 3pcs</li><li>CD/DVD + file edit 50 foto</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 6,
            'paket' => 'Ruby Photo Pack',
            'harga' => '2800000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>1 album magnetic 20 sheet</li><li>Cetak foto 4R 200pcs</li><li>Cetak foto 10R 2pcs</li><li>CD/DVD + file edit 80 foto</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 6,
            'paket' => 'Diamond Photo Pack',
            'harga' => '4000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>1 album magnetic 20 sheet</li><li>Cetak foto 4R 240pcs</li><li>Cetak foto 10R 5pcs</li><li>CD/DVD + file edit 120 foto</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 6,
            'paket' => 'Emerald Video Pack',
            'harga' => '2000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>1 DVD Master</li><li>Dokumentasi full edit (durasi max. 2 jam)</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 6,
            'paket' => 'Ruby Video Pack',
            'harga' => '2200000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>1 DVD Master</li><li>Dokumentasi full edit (durasi max. 2 jam)</li><li>Highlight clip (standard)</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 6,
            'paket' => 'Diamond Video Pack',
            'harga' => '2800000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>1 DVD Master</li><li>Dokumentasi full edit (durasi max. 2 jam)</li><li>Highlight clip (cinematic)</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 6,
            'paket' => 'Bronze Pack',
            'harga' => '3000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>1 album standard</li><li>Cetak foto 4R 120pcs</li><li>Cetak foto 10R 1pcs</li><li>CD/DVD + file edit 50 foto</li><li>1 DVD Master</li><li>Dokumentasi full edit (durasi max. 2 jam)</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 6,
            'paket' => 'Silver Pack',
            'harga' => '4000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>1 album magnetic 20 sheet</li><li>Cetak foto 4R 200pcs</li><li>Cetak foto 10R 2pcs</li><li>CD/DVD + file edit 80 foto</li><li>1 DVD Master</li><li>Dokumentasi full edit (durasi max. 2 jam)</li><li>Highlight clip (standard)</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 6,
            'paket' => 'Gold Pack',
            'harga' => '5000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>1 album magnetic 20 sheet</li><li>Cetak foto 4R 240pcs</li><li>Cetak foto 10R 4pcs</li><li>CD/DVD + file edit 120 foto</li><li>1 DVD Master</li><li>Dokumentasi full edit (durasi max. 2 jam)</li><li>Highlight clip (cinematic)</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 6,
            'paket' => 'Platinum Pack',
            'harga' => '6500000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>1 album magnetic 20 sheet</li><li>Cetak foto 4R 240pcs</li><li>Cetak foto 10R 4pcs</li><li>CD/DVD + file edit 120 foto</li><li>1 DVD Master</li><li>Dokumentasi full edit (durasi max. 2 jam)</li><li>Highlight clip (cinematic)</li><li>Drone shoot</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 5,
            'paket' => 'Product Video',
            'harga' => '250000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>Max. durasi 1 menit</li><li>Max. 1x revisi</li><li>Untuk semua ukuran produk</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 5,
            'paket' => 'Documentation Video',
            'harga' => '3500000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>3 camera (1 master, 2 backup)</li><li>Max. 2x revisi</li><li>Full variation editing</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 5,
            'paket' => 'Party/Sweet 17 Video',
            'harga' => '1500000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>Max. durasi 20 menit</li><li>Max. 2x revisi</li><li>Cinematic modern/classic editing</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 5,
            'paket' => 'Company Profile Standard Video',
            'harga' => '4500000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>Max. durasi 20 menit</li><li>Max. 3x revisi</li><li>Bumper-in/out, menu, visual effect</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 5,
            'paket' => 'Company Profile Exclusive Video',
            'harga' => '7000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>Durasi 20 - 30 menit</li><li>Max. 3x revisi</li><li>Bumper-in/out, menu, visual effect, motion graphic, animasi</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 4,
            'paket' => 'Indoor Studio Single Photo',
            'harga' => '450000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>25% foto terbaik tanpa edit</li><li>5 foto terbaik dengan edit</li><li>Durasi 1 jam (biaya tambahan durasi Rp150.000)</li><li>Cetak foto tambah Rp5.000/foto 4R</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 4,
            'paket' => 'Indoor Single Photo',
            'harga' => '350000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>25% foto terbaik tanpa edit</li><li>5 foto terbaik dengan edit</li><li>Durasi 2 jam (biaya tambahan durasi Rp120.000)</li><li>Cetak foto tambah Rp5.000/foto 4R</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 4,
            'paket' => 'Outdoor Single Photo',
            'harga' => '300000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>25% foto terbaik tanpa edit</li><li>5 foto terbaik dengan edit</li><li>Durasi 5 jam (biaya tambahan durasi Rp100.000)</li><li>Cetak foto tambah Rp5.000/foto 4R</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 4,
            'paket' => 'Indoor Studio Couple Photo',
            'harga' => '550000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>25% foto terbaik tanpa edit</li><li>5 foto terbaik dengan edit</li><li>Durasi 1 jam (biaya tambahan durasi Rp200.000)</li><li>Cetak foto tambah Rp5.000/foto 4R</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 4,
            'paket' => 'Indoor Couple Photo',
            'harga' => '400000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>25% foto terbaik tanpa edit</li><li>5 foto terbaik dengan edit</li><li>Durasi 2 jam (biaya tambahan durasi Rp200.000)</li><li>Cetak foto tambah Rp10.000/foto 4R</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 4,
            'paket' => 'Outdoor Couple Photo',
            'harga' => '350000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>25% foto terbaik tanpa edit</li><li>5 foto terbaik dengan edit</li><li>Durasi 5 jam (biaya tambahan durasi Rp150.000)</li><li>Cetak foto tambah Rp5.000/foto 4R</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 4,
            'paket' => 'Indoor Studio Family Photo',
            'harga' => '700000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>Max. 10 orang</li><li>5 foto terbaik dengan edit</li><li>Durasi 1 jam (biaya tambahan durasi Rp250.000)</li><li>Cetak foto tambah Rp5.000/foto 4R</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 4,
            'paket' => 'Indoor Family Photo',
            'harga' => '450000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>Max. 10 orang</li><li>5 foto terbaik dengan edit</li><li>Durasi 2 jam (biaya tambahan durasi Rp200.000)</li><li>Cetak foto tambah Rp10.000/foto 4R</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 4,
            'paket' => 'Outdoor Family Photo',
            'harga' => '350000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>Max. 10 orang</li><li>25% foto terbaik tanpa edit</li><li>5 foto terbaik dengan edit</li><li>Durasi 5 jam (biaya tambahan durasi Rp150.000)</li><li>Cetak foto tambah Rp5.000/foto 4R</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 4,
            'paket' => 'Indoor Studio Group Photo',
            'harga' => '750000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>Max. 15 orang</li><li>25% foto terbaik tanpa edit</li><li>5 foto terbaik dengan edit</li><li>Durasi 1 jam (biaya tambahan durasi Rp250.000)</li><li>Cetak foto tambah Rp5.000/foto 4R</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 4,
            'paket' => 'Indoor Group Photo',
            'harga' => '550000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>Max. 10 orang</li><li>5 foto terbaik dengan edit</li><li>Durasi 2 jam (biaya tambahan durasi Rp200.000)</li><li>Cetak foto tambah Rp10.000/foto 4R</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 4,
            'paket' => 'Outdoor Group Photo',
            'harga' => '450000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>Max. 10 orang</li><li>25% foto terbaik tanpa edit</li><li>5 foto terbaik dengan edit</li><li>Durasi 5 jam (biaya tambahan durasi Rp150.000)</li><li>Cetak foto tambah Rp5.000/foto 4R</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 4,
            'paket' => 'Small Product Photo (mini studio)',
            'harga' => '80000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>6 foto terbaik dengan edit</li><li>Durasi 1,5 jam</li><li>Produk max. ukuran sepatu</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 4,
            'paket' => 'Small Product Photo (exclude studio)',
            'harga' => '500000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>6 foto terbaik dengan edit</li><li>Max. durasi 3 jam</li><li>Semua produk</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 4,
            'paket' => 'Small Product Photo (include studio)',
            'harga' => '750000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>6 foto terbaik dengan edit</li><li>Max. durasi 1 jam</li><li>Semua produk</li><li>Minus model + makeup</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 4,
            'paket' => 'Small Product Photo (include studio)',
            'harga' => '750000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>6 foto terbaik dengan edit</li><li>Max. durasi 1 jam</li><li>Semua produk</li><li>Minus model + makeup</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 3,
            'paket' => 'Web / Desktop / Mobile Apps Mockup',
            'harga' => '500000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>3 pilihan desain</li><li>Max. 2x revisi</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Logo Design',
            'harga' => '350000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>3 pilihan desain</li><li>Max. 2x revisi</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Poster / Brochure Design',
            'harga' => '150000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>Max. 2x revisi</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Product Design',
            'harga' => '450000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>3 pilihan desain</li><li>Max. 2x revisi</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Banner / Ballyhoo / Backdrop / Photobooth Design',
            'harga' => '250000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>Max. 2x revisi</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Other Design',
            'harga' => '100000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>Max. 2x revisi</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 1,
            'paket' => 'Banner / Ballyhoo / Backdrop / Photobooth Print',
            'harga' => '15000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>Rp15.000/meter</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 1,
            'paket' => 'Poster / Brochure Print',
            'harga' => '10000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>Ukuran kertas A3 (323 x 487 mm)</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 1,
            'paket' => 'Sticker Print',
            'harga' => '15000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>Ukuran kertas A3 (32,3 x 48,7 cm)</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 1,
            'paket' => 'Book / Catalog / Magazine Print',
            'harga' => '25000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>Ukuran kertas A5, A4, A3</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 1,
            'paket' => 'Name Card Print',
            'harga' => '50000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>1 Box (100pcs)</li><li>Ukuran standard (9 x 5 cm)</li></ul>',
        ]);
    }
}
