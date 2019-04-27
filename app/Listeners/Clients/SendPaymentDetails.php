<?php

namespace App\Listeners\Clients;

use App\Events\Clients\PaymentDetails;
use App\Mail\Clients\PaymentDetailsEmail;
use App\User;
use Illuminate\Support\Facades\Mail;

class SendPaymentDetails
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param PaymentDetails $event
     * @return void
     */
    public function handle(PaymentDetails $event)
    {
        Mail::to(User::find($event->data['order']->user_id)->email)->send(new PaymentDetailsEmail($event->data));
    }
}
