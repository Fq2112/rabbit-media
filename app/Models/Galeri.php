<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeris';
    protected $guarded = ['id'];

    public function getPortofolio()
    {
        return $this->belongsTo(Portofolio::class, 'portofolio_id');
    }
}
