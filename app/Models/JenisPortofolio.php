<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPortofolio extends Model
{
    protected $table = 'jenis_portofolios';
    protected $guarded = ['id'];

    public function getPortofolio()
    {
        return $this->hasMany(Portofolio::class, 'jenis_id');
    }
}
