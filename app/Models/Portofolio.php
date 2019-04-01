<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    protected $table = 'portofolios';
    protected $guarded = ['id'];

    public function getJenisPortofolio()
    {
        return $this->belongsTo(JenisPortofolio::class, 'jenis_id');
    }

    public function getGaleri()
    {
        return $this->hasMany(Galeri::class, 'portofolio_id');
    }
}
