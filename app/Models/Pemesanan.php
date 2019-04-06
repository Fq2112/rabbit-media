<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanans';
    protected $guarded = ['id'];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getLayanan()
    {
        return $this->belongsTo(layanan::class, 'layanan_id');
    }

    public function getPayment()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_id');
    }
}
