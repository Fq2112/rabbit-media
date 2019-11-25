<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisLayanan extends Model
{
    protected $table = "jenis_layanans";

    protected $guarded = ['id'];

    public function getLayanan()
    {
        return $this->hasMany(layanan::class,'jenis_id');
    }
}
