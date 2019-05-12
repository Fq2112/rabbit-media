<?php

namespace App\Mail\Clients;

use App\Support\RomanConverter;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentDetailsEmail extends Mailable
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
     * @return \App\Mail\Clients\PaymentDetailsEmail
     */
    public function build()
    {
        $data = $this->data;

        if ($data['order']->status_payment <= 1) {
            if ($data['order']->isAbort == false) {
                return $this->subject('Menunggu Pembayaran ' . $data['payment_category']->name .
                    ' untuk Pesanan ' . $data['invoice'])
                    ->from(env('MAIL_USERNAME'), 'Rabbit Media – Digital Creative Service')
                    ->view('emails.clients.paymentDetails')->with($data);

            } else {
                $subject = $data['order']->payment_id != null ? 'Pembayaran ' . $data['payment_category']->name .
                    ' Anda pada ' . Carbon::parse($data['order']->created_at)->format('l, j F Y') . ' Telah Dibatalkan' :
                    'Pembayaran Pesanan ' . $data['invoice'] . ' Telah Dibatalkan pada Tanggal ' .
                    Carbon::parse($data['order']->updated_at)->isoFormat('DD MMMM YYYY [Pukul] HH:mm');

                return $this->subject($subject)
                    ->from(env('MAIL_USERNAME'), 'Rabbit Media – Digital Creative Service')
                    ->view('emails.clients.paymentAbortedDetails')->with($data);
            }

        } else {
            return $this->subject('Checkout Pesanan dengan Pembayaran ' . $data['payment_category']->name .
                ' Berhasil Dikonfirmasi pada Tanggal ' . Carbon::parse($data['order']->date_payment)
                    ->isoFormat('DD MMMM YYYY [Pukul] HH:mm'))
                ->from(env('MAIL_USERNAME'), 'Rabbit Media – Digital Creative Service')
                ->view('emails.clients.paymentSuccessDetails')->with($data);
        }
    }
}
