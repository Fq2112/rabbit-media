<?php

namespace App\Mail\Clients;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmOrderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data, $check;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $check)
    {
        $this->data = $data;
        $this->check = $check;
    }

    /**
     * Build the message.
     *
     * @return \App\Mail\Clients\ConfirmOrderEmail
     */
    public function build()
    {
        $data = $this->data;
        $check = $this->check;

        if ($check == 'confirm_order') {
            return $this->subject('Pesanan ' . $data['invoice'] . ' Berhasil Dikonfirmasi pada Tanggal ' .
                Carbon::parse($data['order']->updated_at)->isoFormat('DD MMMM YYYY [Pukul] HH:mm'))
                ->from(env('MAIL_USERNAME'), 'Rabbit Media – Digital Creative Service')
                ->view('emails.clients.confirmOrderDetails')->with($data, $check);
        } elseif ($check == 'revert_order') {
            return $this->subject('Konfirmasi Pesanan ' . $data['invoice'] . ' Telah Dibatalkan pada Tanggal ' .
                Carbon::parse($data['order']->updated_at)->isoFormat('DD MMMM YYYY [Pukul] HH:mm'))
                ->from(env('MAIL_USERNAME'), 'Rabbit Media – Digital Creative Service')
                ->view('emails.clients.confirmOrderDetails')->with($data, $check);
        } else {
            return $this->subject('Konfirmasi Pembayaran Pesanan ' . $data['invoice'] .
                ' Telah Dibatalkan pada Tanggal ' . Carbon::parse($data['order']->updated_at)
                    ->isoFormat('DD MMMM YYYY [Pukul] HH:mm'))
                ->from(env('MAIL_USERNAME'), 'Rabbit Media – Digital Creative Service')
                ->view('emails.clients.confirmOrderDetails')->with($data, $check);
        }
    }
}
