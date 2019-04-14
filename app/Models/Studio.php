<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    protected $table = 'studios';
    protected $guarded = ['id'];

    public function getPemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'studio_id');
    }
}
