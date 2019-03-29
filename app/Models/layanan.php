<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class layanan extends Model
{
    protected $table = 'layanans';

    protected $guarded = ['id'];

    public function getJenisLayanan()
    {
        return $this->belongsTo(JenisLayanan::class, 'jenis_id');
    }

    public function getPemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'layanan_id');
    }
}
