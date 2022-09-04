<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AddonPurchaseCancel extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $cartId;
    public $transactionId;
    public $price;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $cartId, $transactionId, $price)
    {
        $this->data = $data;
        $this->cartId = $cartId;
        $this->transactionId = $transactionId;
        $this->price = $price;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('autovilla@gmail.com')
            ->view('email.addon.success');
    }
}
