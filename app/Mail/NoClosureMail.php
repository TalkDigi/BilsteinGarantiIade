<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NoClosureMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;

    /**
     * Create a new message instance.
     */
    public function __construct($customer)
    {
        //
        $this->customer = $customer;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Ay Kapama Bildirimi',
        );
    }



    public function build()
    {

        //bugünün tarihinin sadece ay ve yılını al (örn Ağustos 2024)
        $date = now()->format('F Y');

        Log::info('Customer'.print_r($this->customer,true));


        return $this->markdown('emails.no-closure')
                    ->with([
                        'customerName' => $this->customer->Name,
                        'date' => $date
                    ]);
    }
}
