<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';
    protected $guarded = ['id'];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
