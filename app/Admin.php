<?php

namespace App;

use App\Support\Role;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    protected $table = 'admins';

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

    /**
     * Check whether this user is root or not
     * @return bool
     */
    public function isRoot()
    {
        return ($this->role == Role::ROOT);
    }

    /**
     * Check whether this user is admin or not
     * @return bool
     */
    public function isStaffFoto()
    {
        return ($this->role == Role::STAFF_FOTO);
    }

    public function isStaffVideo()
    {
        return ($this->role == Role::STAFF_VIDEO);
    }

    public function isStaffDesain()
    {
        return ($this->role == Role::STAFF_DESAIN);
    }
}