<?php

namespace App\Models;

use App\Admin;
use Illuminate\Database\Eloquent\Model;

class OrderLogs extends Model
{
    protected $table = 'order_logs';
    protected $guarded = ['id'];

    public function getPemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    public function getAdmin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
