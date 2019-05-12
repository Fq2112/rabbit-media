<?php

namespace App\Mail\Clients;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderDetailsEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return \App\Mail\Clients\OrderDetailsEmail
     */
    public function build()
    {
        $data = $this->data;
        $user = User::find($data['order']->user_id);

        return $this->subject(ucwords($user->name) . ' Menunggu Konfirmasi Pesanan ' . $data['invoice'])
            ->from($user->email, 'Rabbit\'s Client')->view('emails.admins.orderDetails')->with($data);
    }
}
