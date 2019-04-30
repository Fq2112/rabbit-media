<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderRevision extends Model
{
    protected $table = 'order_revisions';
    protected $guarded = ['id'];

    public function getOrderLog()
    {
        return $this->belongsTo(OrderLogs::class, 'log_id');
    }
}
