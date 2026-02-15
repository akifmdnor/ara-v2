<?php

namespace App\Mail\FullPayment;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyAllMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bookingId;
    public $carModel;
    public $pickupDateTime;
    public $pickupLocation;
    public $dropOffDateTime;
    public $dropOffLocation;
    public $customerName;

    public function __construct($data)
    {
        $this->bookingId = $data['bookingId'];
        $this->carModel = $data['carModel'];
        $this->pickupDateTime = $data['pickupDateTime'];
        $this->pickupLocation = $data['pickupLocation'];
        $this->dropOffDateTime = $data['dropOffDateTime'];
        $this->dropOffLocation = $data['dropOffLocation'];
        $this->customerName = $data['customerName'];
    }

    public function build(): NotifyAllMail
    {
        return $this->from('reservation@aracarrental.com.my')
            ->subject("✅ Payment Received – {$this->bookingId} is Now Fully Paid")
            ->view('mail.full-payment.notify-all');
    }
}