<?php

namespace App;

use App\Support\Role;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Messages\MailMessage;
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
    public function isPhotographer()
    {
        return ($this->role == Role::PHOTOGRAPHER);
    }

    public function isVideographer()
    {
        return ($this->role == Role::VIDEOGRAPHER);
    }

    public function isDesigner()
    {
        return ($this->role == Role::DESIGNER);
    }

    /**
     * Sends the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomPasswordAdmin($token));
    }
}

class CustomPasswordAdmin extends ResetPassword
{
    public function toMail($notifiable)
    {
        $data = $this->token;
        return (new MailMessage)
            ->from(env('MAIL_USERNAME'), 'Rabbit Media – Digital Creative Service')
            ->subject('Rabbit Media Account: Admin Reset Password')
            ->view('emails.auth.reset', compact('data'));
    }
}