<?php

namespace App\Mail\Clients;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderLogEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data, $invoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $invoice)
    {
        $this->data = $data;
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $log = $this->data;
        $invoice = $this->invoice;

        $message = $this->subject('Progress/Log Details Pesanan ' . $invoice)
            ->from(env('MAIL_USERNAME'), 'Rabbit Media – Digital Creative Service')
            ->view('emails.clients.orderLogDetails', compact('log', 'invoice'));

        foreach ($log->files as $file) {
            $message->attach(asset('storage/order-logs/' . $file));
        }

        return $message;
    }
}
