<?php

namespace App\Models;

use App\Admin;
use Illuminate\Database\Eloquent\Model;

class OrderLogs extends Model
{
    protected $table = 'order_logs';
    protected $guarded = ['id'];
    protected $casts = ['files' => 'array'];

    public function getPemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    public function getAdmin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function getOrderRevision()
    {
        return $this->hasMany(OrderRevision::class, 'log_id');
    }
}
