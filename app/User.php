<?php

namespace App;

use App\Models\Feedback;
use App\Models\Pemesanan;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function socialProviders()
    {
        return $this->hasMany(SocialProvider::class);
    }

    public function scopeByActivationColumns(Builder $builder, $email, $verifyToken)
    {
        return $builder->where('email', $email)->where('verifyToken', $verifyToken);
    }

    public function getFeedback()
    {
        return $this->hasOne(Feedback::class, 'user_id');
    }

    public function getPemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'user_id');
    }
}
