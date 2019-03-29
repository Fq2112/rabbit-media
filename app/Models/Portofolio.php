<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    protected $table = 'portofolios';
    protected $guarded = ['id'];
    protected $casts = ['photos' => 'array', 'videos' => 'array'];

    public function getJenisPortofolio()
    {
        return $this->belongsTo(JenisPortofolio::class, 'jenis_id');
    }
}
