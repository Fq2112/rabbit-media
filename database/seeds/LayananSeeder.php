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
            'icon' => 'graphic_design.png',
            'nama' => 'Graphic Design',
            'deskripsi' => $faker->sentence
        ]);

        JenisLayanan::create([
            'icon' => 'photography.png',
            'nama' => 'Photography',
            'deskripsi' => $faker->sentence
        ]);

        JenisLayanan::create([
            'icon' => 'videography.png',
            'nama' => 'Videography',
            'deskripsi' => $faker->sentence
        ]);

        JenisLayanan::create([
            'icon' => 'wedding.png',
            'nama' => 'Wedding Pack',
            'deskripsi' => $faker->sentence,
            'isPack' => true
        ]);

        JenisLayanan::create([
            'icon' => 'event.png',
            'nama' => 'Event Pack',
            'deskripsi' => $faker->sentence,
            'isPack' => true
        ]);

        JenisLayanan::create([
            'icon' => 'design.png',
            'nama' => 'Design Pack',
            'deskripsi' => $faker->sentence,
            'isPack' => true
        ]);

        layanan::create([
            'jenis_id' => 5,
            'paket' => 'Bronze Pack',
            'harga' => '1500000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>1 fotografer dan 1 videografer</li><li>2 camera</li><li>max 3 jam kerja</li><li>durasi video highlight max 3 menit</li><li>30 foto edited</li><li>unlimited foto</li><li>flashdisk semua file + edited</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 5,
            'paket' => 'Silver Pack',
            'harga' => '3000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>1 fotografer dan 2 videografer</li><li>3 camera</li><li>max 3 jam kerja</li><li>durasi video highlight max 3 menit</li><li>40 foto edited</li><li>unlimited foto</li><li>cetak album 20x30 10 sheet</li><li>flashdisk 16GB semua file + edited</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 5,
            'paket' => 'Gold Pack',
            'harga' => '6000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>2 fotografer dan 2 videografer</li><li>4 camera</li><li>max 4 jam kerja</li><li>durasi video highlight cinematic max 5 menit</li><li>50 foto edited</li><li>unlimited foto</li><li>cetak album 20x30 10 sheet</li><li>cetak 10R 2pcs</li><li>flashdisk 16GB semua file + edited</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 4,
            'paket' => 'Bronze Pack',
            'harga' => '3500000',
            'diskon' => 0,
            'keuntungan' => '<strong>PHOTO</strong><ul><li>akad nikah / pemberkatan (adat) / resepsi</li><li>1 fotografer dan 1 cameramen + crew</li><li>1 album magnetic 20x30 20 sheet</li><li>cetak foto 4R 150pcs</li><li>cetak foto 10R 4pcs</li></ul><strong>VIDEO</strong><ul><li>akad nikah / pemberkatan (adat) / resepsi</li><li>1 camera HD</li><li>durasi video 1-2 jam</li><li>full editing</li><li>flashdisk 16GB semua file photo + edited, video full</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 4,
            'paket' => 'Silver Pack',
            'harga' => '6000000',
            'diskon' => 0,
            'keuntungan' => '<strong>PHOTO</strong><ul><li>akad nikah / pemberkatan (adat) / resepsi</li><li>2 fotografer dan 1 cameramen + crew</li><li>candid foto</li><li>1 album magazine 20x30 10 sheet</li><li>1 album magnetic 10 sheet</li><li>cetak foto 4R 80pcs foto keluarga</li><li>cetak foto 10R 2pcs + 16R 1pcs</li><li>retouch foto</li><li>unlimited shoot</li></ul><strong>VIDEO</strong><ul><li>akad nikah / pemberkatan (adat) / resepsi</li><li>1 camera full HD</li><li>durasi video 1-2 jam</li><li>full editing</li><li>60 detik video instagram</li><li>flashdisk 16GB semua file photo + edited, video full</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 4,
            'paket' => 'Gold Pack',
            'harga' => '9500000',
            'diskon' => 0,
            'keuntungan' => '<strong>PHOTO</strong><ul><li>akad nikah / pemberkatan (adat) / resepsi</li><li>2 fotografer dan 2 cameramen + crew</li><li>candid foto</li><li>1 album magazine 30x40 10 sheet</li><li>1 album magnetic 10 sheet</li><li>cetak foto 4R 100pcs foto keluarga</li><li>cetak foto 12R 2 pcs + 16R 1pcs</li><li>retouch foto</li><li>unlimited shoot</li></ul><strong>VIDEO</strong><ul><li>akad nikah / pemberkatan (adat) / resepsi</li><li>1 camera full HD</li><li>1 camera DSLR</li><li>durasi video 1-2 jam</li><li>full editing + cinematic (max 5 menit)</li><li>60 detik video instagram</li><li>flashdisk 16-32GB semua file photo + edited, video full</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 4,
            'paket' => 'Platinum Pack',
            'harga' => '12500000',
            'diskon' => 0,
            'keuntungan' => '<strong>PHOTO</strong><ul><li>akad nikah / pemberkatan (adat) / resepsi</li><li>2 fotografer dan 3 cameramen + crew dan 1 pilot drone</li><li>candid foto</li><li>1 album magazine 30x40 15 sheet</li><li>1 album magnetic 10 sheet</li><li>cetak foto 4R 100pcs foto keluarga</li><li>cetak foto 12R 2 pcs + 16R 1pcs ( +frame)</li><li>retouch foto</li><li>unlimited shoot</li></ul><strong>VIDEO</strong><ul><li>akad nikah / pemberkatan (adat) / resepsi</li><li>1 camera full HD</li><li>2 camera DSLR</li><li>1 drone</li><li>durasi video 1-2 jam</li><li>full editing + cinematic (max 5 menit)</li><li>60 detik video instagram</li><li>flashdisk 16-32GB semua file photo + edited, video full</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 3,
            'paket' => 'Small Product Video',
            'harga' => '2000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>1 camera</li><li>durasi max 3 menit</li><li>max 2x revisi</li><li>3 jam kerja</li><li>full editing + cinematic</li><li>flashdisk 16GB full file video</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 3,
            'paket' => 'Big Product Video',
            'harga' => '4000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>2 camera</li><li>durasi max 3 menit</li><li>max 2x revisi</li><li>3 jam kerja</li><li>full editing + cinematic</li><li>flashdisk 16GB full file video</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 3,
            'paket' => 'Pre-wedding Clip (video)',
            'harga' => '6000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>cinematic video</li><li>drone (photo video)</li><li>8 jam kerja</li><li>max 2x revisi</li><li>durasi max 5 menit</li><li>free video clip 1 menit</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 3,
            'paket' => 'Wedding Video Bronze Pack',
            'harga' => '2000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>1 cameramen + crew</li><li>1 camera HD</li><li>8 jam kerja</li><li>dokumentasi full edit</li><li>durasi video 1-2 jam</li><li>flashdisk 16GB full file video</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 3,
            'paket' => 'Wedding Video Silver Pack',
            'harga' => '3000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>2 cameramen + crew</li><li>1 camera HD</li><li>1 camera DSLR</li><li>8 jam kerja</li><li>dokumentasi full edit</li><li>durasi video 1-2 jam</li><li>flashdisk 16GB full file video</li><li>60 detik video instagram</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 3,
            'paket' => 'Wedding Video Gold Pack',
            'harga' => '6000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>3 cameramen + crew</li><li>1 camera HD</li><li>2 camera DSLR</li><li>8 jam kerja</li><li>dokumentasi full edit</li><li>durasi video 1-2 jam + cinematic (max 3 menit)</li><li>flashdisk 16GB full file video</li><li>60 detik video instagram</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Indoor Studio Single Photo',
            'harga' => '250000',
            'diskon' => 0,
            'isHours' => true,
            'hours' => 1,
            'price_per_hours' => '250000',
            'isStudio' => true,
            'keuntungan' => '<ul><li>Semua file</li><li>6 foto terbaik dengan edit + retouched</li><li>cetak foto 4R 6pcs</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Outdoor Single Photo',
            'harga' => '350000',
            'diskon' => 0,
            'isHours' => true,
            'hours' => 2,
            'price_per_hours' => '150000',
            'keuntungan' => '<ul><li>Semua file</li><li>6 foto terbaik dengan edit + retouched</li><li>cetak foto 4R 6pcs</li><li>1 lokasi pemotretan</li><li>tidak termasuk enterance lokasi</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Indoor Studio Couple Photo',
            'harga' => '300000',
            'diskon' => 0,
            'isHours' => true,
            'hours' => 1,
            'price_per_hours' => '300000',
            'isStudio' => true,
            'keuntungan' => '<ul><li>Semua file</li><li>6 foto terbaik dengan edit + retouched</li><li>cetak foto 4R 6pcs</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Outdoor Couple Photo',
            'harga' => '500000',
            'diskon' => 0,
            'isHours' => true,
            'hours' => 2,
            'price_per_hours' => '200000',
            'keuntungan' => '<ul><li>Semua file</li><li>6 foto terbaik dengan edit + retouched</li><li>cetak foto 4R 6pcs</li><li>cetak foto 10R 1pcs</li><li>1 lokasi pemotreatan</li><li>tidak termasuk enterance lokasi</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Indoor Studio Group/Family Photo',
            'harga' => '500000',
            'diskon' => 0,
            'isHours' => true,
            'hours' => 1,
            'price_per_hours' => '300000',
            'isQty' => true,
            'qty' => 10,
            'price_per_qty' => '100000',
            'isStudio' => true,
            'keuntungan' => '<ul><li>Semua file</li><li>6 foto terbaik dengan edit + retouched</li><li>cetak foto 4R 6pcs</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Outdoor Group/Family Photo',
            'harga' => '700000',
            'diskon' => 0,
            'isHours' => true,
            'hours' => 2,
            'price_per_hours' => '250000',
            'isQty' => true,
            'qty' => 10,
            'price_per_qty' => '100000',
            'keuntungan' => '<ul><li>Semua file</li><li>6 foto terbaik dengan edit + retouched</li><li>cetak foto 4R 6pcs</li><li>cetak foto 10R 1pcs</li><li>1 lokasi pemotreatan</li><li>tidak termasuk enterance lokasi</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Small Product Photo (mini studio)',
            'harga' => '100000',
            'diskon' => 0,
            'isQty' => true,
            'qty' => 1,
            'price_per_qty' => '50000',
            'keuntungan' => '<ul><li>3 foto terbaik dengan edit</li><li>produk max ukuran sepatu</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Small Product Photo Pack (mini studio)',
            'harga' => '450000',
            'diskon' => 0,
            'isQty' => true,
            'qty' => 10,
            'price_per_qty' => '50000',
            'keuntungan' => '<ul><li>3 foto terbaik dengan edit/produk</li><li>Produk max ukuran sepatu</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Big Product Photo (indoor studio)',
            'harga' => '500000',
            'diskon' => 0,
            'isHours' => true,
            'hours' => 2,
            'price_per_hours' => '150000',
            'keuntungan' => '<ul><li>6 foto terbaik dengan edit</li><li>semua ukuran produk</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Big Product Photo (outdoor)',
            'harga' => '750000',
            'diskon' => 0,
            'isHours' => true,
            'hours' => 3,
            'price_per_hours' => '200000',
            'isQty' => true,
            'qty' => 8,
            'price_per_qty' => '100000',
            'keuntungan' => '<ul><li>6 foto terbaik dengan edit</li><li>semua ukuran produk</li><li>belum termasuk model + makeup</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Pre-wedding Photo (indoor studio)',
            'harga' => '2500000',
            'diskon' => 0,
            'isStudio' => true,
            'keuntungan' => '<ul><li>makeup</li><li>unlimited foto</li><li>3 jam</li><li>10 foto terbaik dengan edit</li><li>2 kostum/baju</li><li>cetak 16R + frame 6pcs</li><li>flashdisk 16GB semua file photo + edited</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Pre-wedding Photo Bronze Pack (outdoor)',
            'harga' => '3000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>unlimited foto</li><li>20 foto terbaik dengan edit</li><li>8 jam</li><li>2 kostum/baju</li><li>1-2 tempat</li><li>cetak 16R + frame 2pcs</li><li>1 fotografer + asisten</li><li>video 60 detik</li><li>flashdisk 16GB semua file photo + edited</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Pre-wedding Photo Silver Pack (outdoor)',
            'harga' => '5000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>unlimited foto</li><li>30 foto terbaik dengan edit</li><li>8 jam</li><li>2 kostum/baju</li><li>1-2 tempat</li><li>cetak 16R + frame 2pcs</li><li>1 fotografer + asisten</li><li>video 60 detik</li><li>flashdisk 16GB semua file photo + edited</li><li>makeup</li><li>1 album magazine 25x30cm 20 sheet</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Pre-wedding Photo Gold Pack (outdoor)',
            'harga' => '6000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>unlimited foto</li><li>40 foto terbaik dengan edit</li><li>8 jam</li><li>2 kostum/baju</li><li>1-2 tempat</li><li>cetak 16R + frame 2pcs</li><li>1 fotografer + asisten</li><li>video 60 detik</li><li>flashdisk 16GB semua file photo + edited</li><li>makeup</li><li>1 album magazine 25x30cm 30 sheet</li><li>cetak 5R + frame 5pcs</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Wedding Photo Bronze Pack',
            'harga' => '3000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>2 fotografer</li><li>unlimited shoot</li><li>1 album magnetic 20x30 10 sheet</li><li>cetak foto 4R 100pcs</li><li>cetak foto 10R 1pcs</li><li>penyimpanan cloud file 1 tahun</li><li>flashdisk 16GB semua file photo + edited</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Wedding Photo Silver Pack',
            'harga' => '4000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>2 fotografer</li><li>unlimited shoot</li><li>1 album magnetic 20x30 20 sheet</li><li>cetak foto 4R 150pcs</li><li>cetak foto 10R 3pcs</li><li>penyimpanan cloud file 1 tahun</li><li>flashdisk 16GB semua file photo + edited</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 2,
            'paket' => 'Wedding Photo Gold Pack',
            'harga' => '5000000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>2 fotografer</li><li>unlimited shoot</li><li>1 album magnetic 20x30 20 sheet</li><li>1 album magazine 20x30 10 sheet</li><li>cetak foto 4R 150pcs</li><li>cetak foto 10R 3pcs + 16R 1pcs</li><li>penyimpanan cloud file 1 tahun</li><li>flashdisk 16GB semua file photo + edited</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 1,
            'paket' => 'Logo Design',
            'harga' => '350000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>3 pilihan desain</li><li>Max. 2x revisi</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 1,
            'paket' => 'Poster / Brochure Design',
            'harga' => '150000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>2 pilihan desain</li><li>Max. 2x revisi</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 1,
            'paket' => 'Product Design',
            'harga' => '450000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>3 pilihan desain</li><li>Max. 2x revisi</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 1,
            'paket' => 'Banner / Ballyhoo / Backdrop / Photobooth Design',
            'harga' => '250000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>2 pilihan desain</li><li>Max. 2x revisi</li></ul>',
        ]);

        layanan::create([
            'jenis_id' => 1,
            'paket' => 'Other Design',
            'harga' => '100000',
            'diskon' => 0,
            'keuntungan' => '<ul><li>Max. 2x revisi</li></ul>',
        ]);
    }
}
