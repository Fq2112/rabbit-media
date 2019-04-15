<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisStudio extends Model
{
    protected $table = 'jenis_studios';
    protected $guarded = ['id'];

    public function getStudio()
    {
        return $this->hasMany(Studio::class, 'jenis_id');
    }
}
