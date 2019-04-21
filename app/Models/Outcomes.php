<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outcomes extends Model
{
    protected $table = 'outcomes';
    protected $guarded = ['id'];

    public function getPemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }
}
